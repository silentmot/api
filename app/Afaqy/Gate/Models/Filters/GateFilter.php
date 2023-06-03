<?php

namespace Afaqy\Gate\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class GateFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return GateFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('gates.name', 'Like', '%' . $keyword . '%')
            ->orWhere('gates.serial', 'Like', '%' . $keyword . '%');
    }
}
