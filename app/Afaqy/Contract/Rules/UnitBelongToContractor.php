<?php

namespace Afaqy\Contract\Rules;

use Afaqy\Unit\Models\Unit;
use Illuminate\Contracts\Validation\Rule;

class UnitBelongToContractor implements Rule
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
        return (bool) Unit::where('id', $value)
            ->where('contractor_id', request()->contractor_id)
            ->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('contract::contract.unit-not-belong-to-contractor');
    }
}
