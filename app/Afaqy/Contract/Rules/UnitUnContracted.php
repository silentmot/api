<?php

namespace Afaqy\Contract\Rules;

use Afaqy\Contract\Models\Contract;
use Illuminate\Contracts\Validation\Rule;

class UnitUnContracted implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $unit = Contract::withDistrictsIds()->where('unit_id', $value);

        if (request('id')) {
            $unit->where('contract_id', '!=', request('id'));
        }

        return ! (bool) $unit->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('contract::contract.units-unContracted');
    }
}
