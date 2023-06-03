<?php

namespace Afaqy\Role\Models;

use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Laratrust\Models\LaratrustRole;
use Afaqy\Role\Models\Filters\RoleFilter;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends LaratrustRole
{
    use Filterable;
    use SoftDeletes;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at',
    ];

    /**
     * @var boolean
     */
    protected static $logOnlyDirty = true;

    /**
     * @var array
     */
    protected static $logAttributes = ['*'];

    /**
     * @var array
     */
    protected static $logAttributesToIgnore = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Set role filtration class.
     * @return string
     */
    public function modelFilter(): string
    {
        return $this->provideFilter(RoleFilter::class);
    }

    /**
     * Get all of the tags for the post.
     */
    public function notifications()
    {
        return $this->belongsToMany(Notification::class);
    }

    /**
     * Scope a query to join users ids in many to many table.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithUsersIds($query)
    {
        return $query->leftJoin('role_user', 'roles.id', '=', 'role_user.role_id');
    }

    /**
     * Scope a query to join users table.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithUsers($query)
    {
        return $query->withUsersIds()
            ->leftJoin('users', 'users.id', '=', 'role_user.user_id');
    }

    /**
     * Scope a query to join undeleted users table.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithUnDeletedUsers($query)
    {
        return $query->withUsersIds()
            ->leftJoin('users', function ($query) {
                $query->on('users.id', '=', 'role_user.user_id')->whereNull('users.deleted_at');
            });
    }

    /**
     * Scope a query to join role_permission ids in many to many table.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRolePermissionsIds($query)
    {
        return $query->leftJoin('permission_role', 'roles.id', '=', 'permission_role.role_id');
    }

    /**
     * Scope a query to join permission table.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithPermissions($query)
    {
        return $query->withRolePermissionsIds()
            ->leftJoin('permissions', 'permissions.id', '=', 'permission_role.permission_id');
    }

    /**
     * Sort by the given column.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortBy($query, $request)
    {
        if ($request->has('sort')) {
            $column = Str::snake($request->input('sort'));

            if ($request->has('direction') && $request->input('direction') == 'asc') {
                return $query->orderBy($column, 'asc');
            }

            return $query->orderBy($column, 'desc');
        }

        return $query->orderBy($this->getTable() . '.' . 'id', 'desc');
    }
}
