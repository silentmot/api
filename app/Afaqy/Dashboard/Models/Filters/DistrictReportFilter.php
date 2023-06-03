<?php

namespace Afaqy\Dashboard\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class DistrictReportFilter extends ModelFilter
{
    public function districts($names)
    {
        return $this->whereIn('district_name', $names);
    }
}
