<?php

namespace Afaqy\Dashboard\Http\Transformers\Contractors;

use League\Fractal\TransformerAbstract;

class ContractorsChartTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'contractor_name' => $data->contractor_name,
            'total_weight'    => $data->total_weight / 1000,
        ];
    }
}
