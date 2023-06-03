<?php

namespace Afaqy\Activity\Models;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Activity\Models\Filters\ActivityFilter;

use \Spatie\Activitylog\Models\Activity as ActivityLog;

class Activity extends ActivityLog
{
    use Filterable;

    /**
     * Returns ModelFilter class to be instantiated.
     *
     * @return string
     */
    public function modelFilter(): string
    {
        return $this->provideFilter(ActivityFilter::class);
    }

    /**
     * Sort by the given column.
     *
     * @param Builder $query
     * @param Request $request
     * @return Builder
     */
    public function scopeSortBy(Builder $query, Request $request)
    {
        if ($request->has('sort')) {
            $column = Str::snake($request->input('sort'));

            if ($request->has('direction') && $request->input('direction') == 'asc') {
                return $query->orderBy($column, 'asc');
            }

            return $query->orderBy($column, 'desc');
        }

        return $query->orderBy($this->getTable() . '.' .'id', 'desc');
    }
}
