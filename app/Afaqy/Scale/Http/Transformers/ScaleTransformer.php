<?php

namespace Afaqy\Scale\Http\Transformers;

use League\Fractal\TransformerAbstract;

class ScaleTransformer extends TransformerAbstract
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
