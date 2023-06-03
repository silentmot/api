<?php

namespace Afaqy\Contractor\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class ContractorFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return ContractorFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('contractors.name_en', 'Like', '%' . $keyword . '%')
            ->orWhere('contractors.name_ar', 'Like', '%' . $keyword . '%')
            ->orWhere('contractors.employees', 'Like', '%' . $keyword . '%')
            ->orWhere('contacts.name', 'Like', '%' . $keyword . '%')
            ->orWhere('contacts.email', 'Like', '%' . $keyword . '%');
    }
}
