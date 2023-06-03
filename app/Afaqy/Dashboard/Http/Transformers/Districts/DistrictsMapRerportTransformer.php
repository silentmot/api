<?php

namespace Afaqy\Dashboard\Http\Transformers\Districts;

use League\Fractal\TransformerAbstract;

class DistrictsMapRerportTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        $data   = $data->groupBy('district_name')->toArray();
        $result = [];
        $count  = 0;

        foreach ($data as $name => $districts) {
            $result[$count] = [
                'name'   => $districts[0]['district_name'],
                'point'  => json_decode($districts[0]['district_point'], true),
                'weight' => 0,
            ];

            foreach ($districts as $key => $neighborhood) {
                $result[$count]['weight'] += $neighborhood['weight'];

                $result[$count]['neighborhoods'][] = [
                    'name'   => $neighborhood['neighborhood_name'],
                    'point'  => json_decode($neighborhood['neighborhood_point'], true),
                    'weight' => $neighborhood['weight'],
                ];
            }

            $count++;
        }

        return $result;
    }
}
