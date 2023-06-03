<?php

namespace Afaqy\User\Models;

use Afaqy\Role\Models\Role;
use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Afaqy\Inspector\Models\Image;
use Laravel\Passport\HasApiTokens;
use Afaqy\Inspector\Models\Response;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Afaqy\User\Models\Filters\UserFilter;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use Filterable;
    use SoftDeletes;
    use HasApiTokens;
    use LaratrustUserTrait;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'avatar',
        'phone',
        'status',
        'use_mob',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
        'password',
        'remember_token',
        'email_verified_at',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Ticket has zero or many Image
     * Get the ticket's images
     * @return morphMany
     */
    public function images(): morphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Ticket has zero or many responses
     * Get the ticket's responses
     * @return morphMany
     */
    public function responses(): morphMany
    {
        return $this->morphMany(Response::class, 'responseable');
    }

    /**
     * Set user filtration class.
     * @return string
     */
    public function modelFilter(): string
    {
        return $this->provideFilter(UserFilter::class);
    }

    /**
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return self
     */
    public function findForPassport($username): self
    {
        $column = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return $this->where($column, $username)
            ->where('deleted_at', null)
            ->first();
    }

    /**
     * Get the users's roles ids.
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRolesIds($query)
    {
        return $query->leftjoin('role_user', 'role_user.user_id', '=', 'users.id');
    }

    /**
     * Get the user's role id.
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithRoles($query)
    {
        return $query->WithRolesIds()->leftjoin('roles', 'roles.id', '=', 'role_user.role_id');
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

        return $query->orderBy($this->getTable().".".'id', 'desc');
    }
}
