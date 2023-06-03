<?php

namespace Afaqy\Dashboard\Http\Transformers\WasteTypes;

use League\Fractal\TransformerAbstract;

class WasteTypesChartTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'waste_type'   => $data->waste_type,
            'total_weight' => $data->total_weight / 1000,
        ];
    }
}
