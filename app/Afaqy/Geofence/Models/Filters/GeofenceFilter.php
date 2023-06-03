<?php

namespace Afaqy\Geofence\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class GeofenceFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return GeofenceFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('geofences.name', 'Like', '%' . $keyword . '%')
            ->orWhere('geofences.geofence_id', 'Like', '%' . $keyword . '%');
    }

    /**
     * @param  string $type
     * @return GeofenceFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function type($type)
    {
        return $this->where('geofences.type', $type);
    }
}
