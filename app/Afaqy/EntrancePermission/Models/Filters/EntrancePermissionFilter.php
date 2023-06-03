<?php

namespace Afaqy\EntrancePermission\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class EntrancePermissionFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return EntrancePermissionFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('entrance_permissions.id', 'Like', '%' . $keyword . '%')
            ->orWhere('entrance_permissions.name', 'Like', '%' . $keyword . '%')
            ->orWhere('entrance_permissions.plate_number', 'Like', '%' . $keyword . '%');
    }
}
