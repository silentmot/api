<?php

namespace Afaqy\User\Http\Transformers;

use League\Fractal\TransformerAbstract;

class UserPermissionsTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        $permissions = [];

        foreach ($data as $key => $permission) {
            $permissions[$permission['module']][] = [
                'id'           => $permission['id'],
                'name'         => $permission['name'],
                'display_name' => $permission['display_name'],
                'is_selected'  => ($permission['is_selected'] || $permission['user_id'] == 1) ? true : false,
            ];
        }

        return $permissions;
    }
}
