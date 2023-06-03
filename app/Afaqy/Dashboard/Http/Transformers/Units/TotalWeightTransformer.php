<?php

namespace Afaqy\Dashboard\Http\Transformers\Units;

use League\Fractal\TransformerAbstract;

class TotalWeightTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'total_weight' => $data->total_weight / 1000,
        ];
    }
}
