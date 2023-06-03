<?php

namespace Afaqy\District\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class DistrictsFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return DistrictFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->having('districts.name', 'Like', '%' . $keyword . '%');
    }

    /**
     * @param  boolean $status
     * @return DistrictFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function active(bool $status)
    {
        return $this->where('districts.status', $status);
    }
}
