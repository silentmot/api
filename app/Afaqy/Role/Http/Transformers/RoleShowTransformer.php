<?php

namespace Afaqy\Role\Http\Transformers;

use League\Fractal\TransformerAbstract;

class RoleShowTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'permissions',
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'role_name' => $data->first()->role_name,
        ];
    }

    /**
     * Transform permissions .
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\item
     */
    public function includePermissions($data)
    {
        return $this->item($data, new RolePermissionsTransformer);
    }
}
