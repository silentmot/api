<?php

namespace Afaqy\Gate\Http\Transformers;

use League\Fractal\TransformerAbstract;

class GateTransformer extends TransformerAbstract
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
            'id'          => (int) $data['id'],
            'name'        => (string) $data['name'],
            'serial'      => (int) $data['serial'],
            'direction'   => ($data['direction'] == 'in') ? 'دخول' : 'خروج',
        ];
    }
}
