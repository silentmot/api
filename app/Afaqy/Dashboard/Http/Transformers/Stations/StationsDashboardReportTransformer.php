<?php

namespace Afaqy\Dashboard\Http\Transformers\Stations;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class StationsDashboardReportTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'date'            => $this->getDate($data->date),
            'station'         => $data->station_name,
            'contract_number' => 'عقد ' . $data->contract_number,
            'total_weight'    => ((int) $data->total_weight) / 1000,
        ];
    }

    public function getDate($date)
    {
        $type = request()->type ?? 'daily';

        if ($type == 'weekly') {
            [$year, $month, $week] = explode('-', $date);

            return Carbon::now()->setISODate($year, $week)->startOfWeek(Carbon::SATURDAY)->toDateString();
        }

        if ($type == 'monthly') {
            return Carbon::parse($date)->toDateString();
        }

        return $date;
    }
}
