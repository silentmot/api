<?php

namespace Afaqy\District\Http\Transformers;

use League\Fractal\TransformerAbstract;

class DistrictShowTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'neighborhoods',
    ];

    /**
     * @param  mixed   $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'     => $data[0]['id'],
            'name'   => $data[0]['name'],
            'points' => json_decode($data[0]['points'], true),
            'status' => (bool) $data[0]['status'],
        ];
    }

    /**
     * Transform neighborhoods count.
     *
     * @param  mixed                                $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeNeighborhoods($data)
    {
        $neighborhoods = [];

        foreach ($data as $key => $neighborhood) {
            $neighborhoods[] = [
                'id'                  => $neighborhood['neighborhood_id'],
                'name'                => $neighborhood['neighborhood_name'],
                'population'          => $neighborhood['neighborhood_population'],
                'neighborhood_points' => json_decode($neighborhood['neighborhood_points'], true),
                'status'              => (bool) $neighborhood['neighborhood_status'],
                'sub_neighborhoods'   => explode(',', $neighborhood['sub_neighborhoods']),
            ];
        }

        return $this->primitive($neighborhoods);
    }
}
