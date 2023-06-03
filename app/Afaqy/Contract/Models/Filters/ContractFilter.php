<?php

namespace Afaqy\Contract\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class ContractFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return ContractFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('contracts.id', '=', $keyword)
            ->orWhere('contractors.name_ar', 'Like', '%' . $keyword . '%')
            ->orWhere('contacts.name', 'Like', '%' . $keyword . '%')
            ->orWhere('contacts.email', 'Like', '%' . $keyword . '%')
            ->orWhere('contracts.contract_number', 'Like', '%' . $keyword . '%');
    }
}
