<?php

namespace Afaqy\District\Http\Transformers;

use League\Fractal\TransformerAbstract;

class NeighborhoodTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'   => $data['id'],
            'name' => $data['name'],
        ];
    }
}
