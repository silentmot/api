<?php

namespace Afaqy\Dashboard\Http\Transformers\Charts;

use League\Fractal\TransformerAbstract;

class DboardWasteTypesInfoTodayTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'waste_type'    => $data->waste_type,
            'total_weights' => $data->total_weights / 1000,
        ];
    }
}
