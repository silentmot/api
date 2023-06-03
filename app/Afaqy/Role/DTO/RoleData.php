<?php

namespace Afaqy\Role\DTO;

use Illuminate\Http\Request;
use Afaqy\Role\Models\Permission;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class RoleData extends FlexibleDataTransferObject
{
    /** @var int|null */
    public $id = null;

    /** @var string */
    public $role_name;

    /** @var array|null */
    public $notifications = null;

    /** @var array */
    public $permissions;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return self
     */
    public static function fromRequest(Request $request, ? int $id = null) : self
    {
        $permissions = [];

        $request_permissions = array_filter($request->permissions);

        if ($request_permissions) { // add read permission by default to any other permissions
            $read_permissions = Permission::select(['id'])->whereIn('module', array_keys($request_permissions))
                ->where('name', 'like', 'read-%')
                ->get()
                ->pluck('id')
                ->all();

            foreach ($request_permissions as $key => $permission) {
                foreach ($permission as $value) {
                    $permissions[] = $value;
                }
            }

            $permissions = array_unique(array_merge($permissions, $read_permissions), SORT_NUMERIC);
        }

        return new self([
            'id'            => $id,
            'role_name'     => $request->role_name,
            'notifications' => $request->notifications ?? null,
            'permissions'   => $permissions,
        ]);
    }
}
