<?php

namespace Afaqy\Dashboard\Http\Reports\PerHour;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\Dashboard\Facades\ReportPeriod;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Facades\ConvertTimezone;
use Afaqy\Dashboard\Http\Transformers\PerHour\PerHourChartTransformer;

class PerHourChartReport extends Report
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
            new PerHourChartTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        [$start, $end] = ReportPeriod::get($this->request);

        return Dashboard::select([
            DB::raw(ConvertTimezone::column('start_time')->as('date')->format('%Y-%m-%d')->toString()),
            DB::raw("count(`unit_id`) as units_count"),
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) AS total_weight"),
        ])
            ->dateBetween($start, $end)
            ->tripCompleted()
            ->withoutSotringPermission()
            ->groupBy([
                DB::raw(ConvertTimezone::column('start_time')->format('%Y-%m-%d')->toString()),
            ])
            ->orderBy('date', 'desc');
    }
}
