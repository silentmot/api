<?php

namespace Afaqy\Role\Http\Transformers;

use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'usersCount',
        'permissionsNames',
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'           => $data['id'],
            'display_name' => $data['display_name'],
        ];
    }

    /**
     * Transform users count.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeUsersCount($data)
    {
        return $this->primitive((int) $data['users_count']);
    }

    /**
     * Transform permissions names.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includePermissionsNames($data)
    {
        return $this->primitive(explode(',', $data['permissions']));
    }
}
