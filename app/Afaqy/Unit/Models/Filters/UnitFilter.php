<?php

namespace Afaqy\Unit\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class UnitFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return UnitFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('units.code', 'Like', '%' . $keyword . '%')
            ->orWhere('units.model', 'Like', '%' . $keyword . '%')
            ->orWhere('unit_types.name', 'Like', '%' . $keyword . '%')
            ->orWhere('waste_types.name', 'Like', '%' . $keyword . '%')
            ->orWhere('contractors.name_ar', 'Like', '%' . $keyword . '%');
    }
}
