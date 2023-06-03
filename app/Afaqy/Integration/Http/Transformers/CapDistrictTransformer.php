<?php

namespace Afaqy\Integration\Http\Transformers;

use League\Fractal\TransformerAbstract;

class CapDistrictTransformer extends TransformerAbstract
{
    /**
     * @param  mixed   $data
     * @return array
     */
    public function transform($data): array
    {
        $data = $data->groupBy('id');

        $result = [];
        $key    = 0;

        foreach ($data as $district) {
            $result[$key] = [
                'id'   => $district->first()->id,
                'name' => $district->first()->name,
            ];

            foreach ($district as $neighborhood) {
                $result[$key]['neighborhoods'][] = [
                    'id'   => $neighborhood->neighborhood_id,
                    'name' => $neighborhood->neighborhood_name,
                ];
            }

            $key++;
        }

        return $result;
    }
}
