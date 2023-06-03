<?php

namespace Afaqy\Scale\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class ScaleFilter extends ModelFilter
{
    /**
     * @param string $keyword
     * @return ScaleFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('scales.name', 'Like', '%' . $keyword . '%');
    }

    /**
     * @param string $type
     * @return ScaleFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function type(string $type)
    {
        $zoneType = ($type == 'in') ? 'entranceScale' : 'exit';

        return $this->join('zones', 'scales.zone_id', '=', 'zones.id')
            ->where('zones.type', $zoneType);
    }
}
