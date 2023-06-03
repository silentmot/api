<?php

namespace Afaqy\Dashboard\Http\Transformers\Contractors;

use League\Fractal\TransformerAbstract;

class ContractorsTotalWeightTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        $total_weight = 0;

        $result = [
            'weight_date'     => 'الكل',
            'contractor_name' => '-',
        ];

        foreach ($data as $waste) {
            $result[$waste->waste_type] = $waste->waste_weight / 1000;

            $total_weight += $waste->waste_weight;
        }

        $result['total_weight'] = $total_weight / 1000;

        return $result;
    }
}
