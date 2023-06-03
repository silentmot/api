<?php

namespace Afaqy\Dashboard\Http\Transformers\Districts;

use League\Fractal\TransformerAbstract;

class DistrictsChartTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'district_name' => $data->district_name,
            'total_weight'  => $data->total_weight / 1000,
        ];
    }
}
