<?php

namespace Afaqy\Contract\Http\Transformers\Show;

use League\Fractal\TransformerAbstract;

class ContractDistrictsTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($result): array
    {
        foreach ($result as $key => $data) {
            if ($key == 0) {
                $districts[$key] = [
                    'district_id'       => $data['district_id'],
                    'district_name'     => $data['district_name'],
                    'neighborhood_id'   => $data['neighborhood_id'],
                    'neighborhood_name' => $data['neighborhood_name'],
                    'units'             => [
                        [
                            'id'           => $data['unit_id'],
                            'plate_number' => $data['plate_number'],
                        ],
                    ],
                ];

                continue;
            }

            if (
                $data['district_id'] != $districts[array_key_last($districts)]['district_id']
                || $data['neighborhood_id'] != $districts[array_key_last($districts)]['neighborhood_id']
            ) {
                $districts[array_key_last($districts) + 1] = [
                    'district_id'       => $data['district_id'],
                    'district_name'     => $data['district_name'],
                    'neighborhood_id'   => $data['neighborhood_id'],
                    'neighborhood_name' => $data['neighborhood_name'],
                    'units'             => [
                        [
                            'id'           => $data['unit_id'],
                            'plate_number' => $data['plate_number'],
                        ],
                    ],
                ];

                continue;
            }

            $districts[array_key_last($districts)]['units'][] = [
                'id'           => $data['unit_id'],
                'plate_number' => $data['plate_number'],
            ];
        }

        return $districts;
    }
}
