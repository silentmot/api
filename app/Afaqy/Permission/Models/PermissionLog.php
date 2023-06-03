<?php

namespace Afaqy\Permission\Models;

use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Afaqy\Permission\Models\Filters\PermissionFilter;

class PermissionLog extends Model
{
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission_number',
        'permission_type',
        'allowed_weight',
        'actual_weight',
    ];

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
