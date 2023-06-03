<?php

namespace Afaqy\Dashboard\Http\Transformers\PerHour;

use League\Fractal\TransformerAbstract;

class PerHourDashboardReportTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'hour'         => $data->hour . ':00',
            'date'         => $data->date,
            'units_count'  => $data->units_count,
            'total_weight' => ((int) $data->total_weight) / 1000,
        ];
    }
}
