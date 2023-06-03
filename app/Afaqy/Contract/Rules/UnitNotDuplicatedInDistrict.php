<?php

namespace Afaqy\Contract\Rules;

use Illuminate\Contracts\Validation\Rule;

class UnitNotDuplicatedInDistrict implements Rule
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
        $duplication = 0;
        $districts   = request()->districts;

        foreach ($districts as $key => $district) {
            if (in_array($value, $district['units_ids'])) {
                $duplication++;
            }
        }

        return ! $duplication;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('contract::contract.unit-duplicated');
    }
}
