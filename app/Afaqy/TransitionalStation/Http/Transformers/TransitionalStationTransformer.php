<?php

namespace Afaqy\TransitionalStation\Http\Transformers;

use League\Fractal\TransformerAbstract;

class TransitionalStationTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'districtsCount',
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
     * Transform districts count.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includedistrictsCount($data)
    {
        return $this->primitive((int) $data['districts_count']);
    }
}
