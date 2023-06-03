<?php

namespace Afaqy\Permission\Models;

use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Afaqy\Permission\Models\Filters\PermissionFilter;

class Permission extends Model
{
    use Filterable;
    use LogsActivity;

    /**
     * @var string
     */
    public $table = 'permissions_list';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be logged.
     *
     * @var array
     */
    protected static $logAttributes = ['*'];

    /**
     * Returns ModelFilter class to be instantiated.
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(PermissionFilter::class);
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

        return $query->orderBy($this->getTable() . '.' .'created_at', 'desc');
    }
}
