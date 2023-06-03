<?php

namespace Afaqy\Device\Http\Transformers;

use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class DeviceTransformer extends TransformerAbstract
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
            'type'        => (string) Str::upper($data['type']),
        ];
    }
}
