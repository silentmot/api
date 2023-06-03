<?php

namespace Afaqy\TransitionalStation\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class TransitionalStationFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return TransitionalStationFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('transitional_stations.name', 'Like', '%' . $keyword . '%');
    }

    /**
     * @param  boolean $status
     * @return TransitionalStationFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function active(bool $status)
    {
        return $this->where('transitional_stations.status', $status);
    }
}
