<?php

namespace Afaqy\Dashboard\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class StationsReportFilter extends ModelFilter
{
    public function stations($names)
    {
        return $this->whereIn('station_name', $names);
    }
}
