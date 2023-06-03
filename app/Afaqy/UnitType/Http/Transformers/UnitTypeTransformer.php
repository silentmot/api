<?php

namespace Afaqy\UnitType\Http\Transformers;

use League\Fractal\TransformerAbstract;

class UnitTypeTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'unitsCount',
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'    => $data['id'],
            'name'  => $data['name'],
        ];
    }

    /**
     * Transform units count.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeUnitsCount($data)
    {
        return $this->primitive((int) $data['units_count']);
    }
}
