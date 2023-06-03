<?php

namespace Afaqy\Dashboard\Http\Reports\Charts;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Facades\ConvertTimezone;
use Afaqy\Dashboard\Http\Transformers\Charts\DboardWeightsCountPerHourTodayTransformer;

class DashboardWeightsCountPerHourTodayReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        $result = $this->fillEmptyHours($this->query()->get());

        $data = $this->fractalCollection($result, new DboardWeightsCountPerHourTodayTransformer);

        return $this->returnSuccess('', $data);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Dashboard::select([
            DB::raw(ConvertTimezone::column('start_time')->as('hour')->format('%H')->toString()),
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) as weights_count"),
            DB::raw("count(`plate_number`) as units_count"),
        ])
            ->today()
            ->withoutSotringPermission()
            ->tripCompleted()
            ->groupBy('hour');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Collection $rows
     * @return array
     */
    private function fillEmptyHours($hours): array
    {
        if ($hours->count() == 24) {
            return $hours->toArray();
        }

        $row_days = Carbon::today()->hoursUntil(Carbon::today()->endOfDay());

        foreach ($row_days as $day) {
            $days[] = [
                'hour'          => $day->format('H'),
                'weights_count' => 0,
                'units_count'   => 0,
            ];
        }

        $hours = collect($hours->toArray());

        return $hours->merge($days)->unique('hour')->sortBy('hour')->values()->all();
    }
}
