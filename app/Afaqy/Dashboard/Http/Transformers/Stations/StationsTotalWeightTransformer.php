<?php

namespace Afaqy\Dashboard\Http\Transformers\Stations;

use League\Fractal\TransformerAbstract;

class StationsTotalWeightTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'date'            => '-',
            'station'         => '-',
            'contract_number' => '-',
            'total_weight'    => ((int) $data->total_weight) / 1000,
        ];
    }
}
