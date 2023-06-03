<?php

namespace Afaqy\UnitType\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class UnitTypeFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return UnitTypeFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('unit_types.name', 'Like', '%' . $keyword . '%');
    }
}
