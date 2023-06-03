<?php

namespace Afaqy\Dashboard\Http\Reports\Violations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\Dashboard\Facades\ReportPeriod;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\StationsReportFilter;
use Afaqy\Dashboard\Http\Transformers\Violations\StationsTotalWeightTransformer;

class ViolationsTotalWeightReport extends Report
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
            new StationsTotalWeightTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        [$start, $end] = ReportPeriod::get($this->request);

        return Dashboard::select([
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) AS total_weight"),
        ])
            ->dateBetween($start, $end)
            ->tripCompleted()
            ->whereNotNull('station_name')
            ->filter($this->request->all(), StationsReportFilter::class);
    }
}
