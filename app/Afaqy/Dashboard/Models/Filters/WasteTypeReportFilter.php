<?php

namespace Afaqy\Dashboard\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class WasteTypeReportFilter extends ModelFilter
{
    public function wastes($types)
    {
        return $this->whereIn('waste_type', $types);
    }
}
