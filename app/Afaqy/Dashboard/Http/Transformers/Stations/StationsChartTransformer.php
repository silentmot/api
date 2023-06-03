<?php

namespace Afaqy\Dashboard\Http\Transformers\Stations;

use League\Fractal\TransformerAbstract;

class StationsChartTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'station'      => $data->station_name,
            'total_weight' => ((int) $data->total_weight) / 1000,
        ];
    }
}
