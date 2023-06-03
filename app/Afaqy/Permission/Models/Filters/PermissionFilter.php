<?php

namespace Afaqy\Permission\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class PermissionFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return PermissionFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('permissions_list.permission_number', 'Like', '%' . $keyword . '%')
            ->orWhere('permissions_list.allowed_weight', 'Like', '%' . $keyword . '%')
            ->orWhere('permissions_list.type', 'Like', '%' . $keyword . '%')
            ->orWhere('permissions_list.actual_weight', 'Like', '%' . $keyword . '%');
    }
}
