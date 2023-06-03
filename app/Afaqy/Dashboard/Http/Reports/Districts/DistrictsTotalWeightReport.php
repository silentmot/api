<?php

namespace Afaqy\Dashboard\Http\Reports\Districts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\Dashboard\Facades\ReportPeriod;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\DistrictReportFilter;
use Afaqy\Dashboard\Http\Transformers\Districts\DistrictsTotalWeightTransformer;

class DistrictsTotalWeightReport extends Report
{
    use Generator;

    /**
     * @var \Illuminate\Http\Request $request
     */
    private $request;

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateJoinViewShow(
            $this->query(),
            new DistrictsTotalWeightTransformer,
            [],
            false
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        [$start, $end] = ReportPeriod::get($this->request);

        return Dashboard::select([
            'waste_type',
            DB::raw('sum(enterance_weight) - sum(exit_weight) as waste_weight'),
        ])
            ->dateBetween($start, $end)
            ->whereNotNull('district_name')
            ->filter($this->request->all(), DistrictReportFilter::class)
            ->tripCompleted()
            ->groupBy(['waste_type'])
            ->orderBy('waste_type', 'asc');
    }
}
