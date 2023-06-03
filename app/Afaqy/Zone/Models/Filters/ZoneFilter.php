<?php

namespace Afaqy\Zone\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class ZoneFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return ZoneFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('zones.name', 'Like', '%' . $keyword . '%')
            ->orWhere('scales.name', 'Like', '%' . $keyword . '%')
            ->orWhere('devices.name', 'Like', '%' . $keyword . '%');
    }

    /**
     * @param  string $type
     * @return ZoneFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function type(string $type)
    {
        return $this->where('zones.type', $type);
    }
}
