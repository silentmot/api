<?php

namespace Afaqy\Dashboard\Http\Transformers\Charts;

use League\Fractal\TransformerAbstract;

class DboardTotalSystemInfoTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'total_system_units'   => (int) $data->first()->total,
            'total_system_weights' => $data->last()->total / 1000,
        ];
    }
}
