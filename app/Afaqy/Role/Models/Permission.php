<?php

namespace Afaqy\Role\Models;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pivot', 'created_at', 'updated_at',
    ];

    /**
     * The roles ids that belong to permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int|null  $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRolesIds($query, ?int $id = null)
    {
        return $query->leftJoin('permission_role', function ($query) use ($id) {
            $query->on('permission_role.permission_id', '=', 'permissions.id');

            if ($id) {
                $query->where('permission_role.role_id', '=', $id);
            }

            return $id;
        });
    }

    /**
     * The roles that belong to permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int|null  $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRoles($query, ?int $id = null)
    {
        return $query->withRolesIds($id)
            ->leftJoin('roles', 'permission_role.role_id', '=', 'roles.id');
    }
}
