<?php

namespace Afaqy\Device\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class DeviceFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return DeviceFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('devices.name', 'Like', '%' . $keyword . '%')
            ->orWhere('devices.type', 'Like', '%' . $keyword . '%');
    }
}
