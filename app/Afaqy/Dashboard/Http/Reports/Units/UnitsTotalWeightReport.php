<?php

namespace Afaqy\Dashboard\Http\Reports\Units;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\Dashboard\Facades\ReportPeriod;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\UnitReportFilter;
use Afaqy\Dashboard\Http\Transformers\Units\TotalWeightTransformer;

class UnitsTotalWeightReport extends Report
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
        return $this->generateViewShow(
            $this->query(),
            new TotalWeightTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        [$start, $end] = ReportPeriod::get($this->request);

        return Dashboard::select([
            DB::raw('sum(enterance_weight) - sum(exit_weight) as total_weight'),
        ])
            ->filter($this->request->all(), UnitReportFilter::class)
            ->dateBetween($start, $end)
            ->withoutSotringPermission()
            ->tripCompleted()
            ->orderBy('start_time', 'desc');
    }
}
