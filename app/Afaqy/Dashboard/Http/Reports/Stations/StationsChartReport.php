<?php

namespace Afaqy\Dashboard\Http\Reports\Stations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\Dashboard\Facades\ReportPeriod;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\StationsReportFilter;
use Afaqy\Dashboard\Http\Transformers\Stations\StationsChartTransformer;

class StationsChartReport extends Report
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
        return $this->generateSelectList(
            $this->query(),
            new StationsChartTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        [$start, $end] = ReportPeriod::get($this->request);

        return Dashboard::select([
            'station_name',
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) AS total_weight"),
        ])
            ->dateBetween($start, $end)
            ->tripCompleted()
            ->whereNotNull('station_name')
            ->filter($this->request->all(), StationsReportFilter::class)
            ->groupBy(['station_name'])
            ->orderBy('station_name', 'asc');
    }
}
