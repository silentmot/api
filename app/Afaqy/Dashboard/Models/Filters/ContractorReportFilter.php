<?php

namespace Afaqy\Dashboard\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class ContractorReportFilter extends ModelFilter
{
    public function contractors($names)
    {
        return $this->whereIn('contractor_name', $names);
    }
}
