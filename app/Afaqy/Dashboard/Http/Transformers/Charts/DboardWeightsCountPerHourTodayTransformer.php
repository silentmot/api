<?php

namespace Afaqy\Dashboard\Http\Transformers\Charts;

use League\Fractal\TransformerAbstract;

class DboardWeightsCountPerHourTodayTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'hour'          => $data['hour'],
            'total_weights' => $data['weights_count'] ? $data['weights_count'] / 1000 : 0,
            'total_units'   => $data['units_count'],
        ];
    }
}
