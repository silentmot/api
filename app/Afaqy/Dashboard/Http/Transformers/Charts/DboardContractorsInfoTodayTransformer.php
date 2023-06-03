<?php

namespace Afaqy\Dashboard\Http\Transformers\Charts;

use League\Fractal\TransformerAbstract;

class DboardContractorsInfoTodayTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'contractor_name'  => $data->contractor_name,
            'total_weights'    => $data->total_weights / 1000,
        ];
    }
}
