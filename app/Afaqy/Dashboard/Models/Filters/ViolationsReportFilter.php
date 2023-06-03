<?php

namespace Afaqy\Dashboard\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class ViolationsReportFilter extends ModelFilter
{
    public function type($names)
    {
        return $this->whereIn('violations_logs.violation_type', $names);
    }
}
