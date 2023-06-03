<?php

namespace Afaqy\Dashboard\Http\Reports\Charts;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Facades\ConvertTimezone;
use Afaqy\Dashboard\Http\Transformers\Charts\DboardLastWeekTotalWeightsTransformer;

class DashboardLastWeekTotalWeightsReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        $result = $this->fillEmptyWeekDays($this->query()->get());

        $data = $this->fractalCollection($result, new DboardLastWeekTotalWeightsTransformer);

        return $this->returnSuccess('', $data);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Dashboard::select([
            DB::raw(ConvertTimezone::column('start_time')->as('date')->format('%Y-%m-%d')->toString()),
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) as total_weight"),
        ])
            ->lastWeek()
            ->withoutSotringPermission()
            ->tripCompleted()
            ->groupBy('date')
            ->orderBy('date', 'desc');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Collection $rows
     * @return array
     */
    private function fillEmptyWeekDays($rows): array
    {
        if ($rows->count() == 7) {
            return $rows->toArray();
        }

        $week = Carbon::today()->subWeek()->daysUntil(Carbon::yesterday());

        foreach ($week as $day) {
            $days[] = [
                'date'         => $day->toDateString(),
                'total_weight' => 0,
            ];
        }

        $rows = collect($rows->toArray());
        $days = array_reverse($days);

        return $rows->merge($days)->unique('date')->sortByDesc('date')->values()->all();
    }
}
