<?php

namespace Afaqy\WasteType\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class WasteTypeFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return WasteTypeFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('waste_types.name', 'Like', '%' . $keyword . '%');
    }
}
