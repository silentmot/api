<?php

namespace Afaqy\District\Http\Transformers;

use League\Fractal\TransformerAbstract;

class DistrictTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'neighborhoodsCount',
        'subNeighborhoodsCount',
        'unitsCount',
    ];

    /**
     * @param  mixed   $data
     * @return array
     */
    public function transform($data): array
    {
        $result = [
            'id'   => $data['id'],
            'name' => $data['name'],
        ];

        if ($data['points'] ?? null) {
            $result['points'] = json_decode($data['points'], true);
        }

        return $result;
    }

    /**
     * Transform neighborhoods count.
     *
     * @param  mixed                                $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeNeighborhoodsCount($data)
    {
        return $this->primitive((int) $data['neighborhoods_count']);
    }

    /**
     * Transform sub neighborhoods count.
     *
     * @param  mixed                                $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeSubNeighborhoodsCount($data)
    {
        return $this->primitive((int) $data['sub_neighborhoods_count']);
    }

    /**
     * Transform units count.
     *
     * @param  mixed                                $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeUnitsCount($data)
    {
        return $this->primitive((int) $data['units_count']);
    }
}
