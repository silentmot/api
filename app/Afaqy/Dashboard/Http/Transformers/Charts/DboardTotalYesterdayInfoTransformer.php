<?php

namespace Afaqy\Dashboard\Http\Transformers\Charts;

use League\Fractal\TransformerAbstract;

class DboardTotalYesterdayInfoTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'districts_count'    => $data->districts_count,
            'units_count'        => $data->units_count,
            'contractors_count'  => $data->contractors_count,
            'waste_types_count'  => $data->waste_types_count,
            'total_weights'      => $data->total_weights / 1000,
        ];
    }
}
