<?php

namespace Afaqy\Role\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class RoleFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return RoleFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->having('roles.display_name', 'Like', '%' . $keyword . '%');
    }
}
