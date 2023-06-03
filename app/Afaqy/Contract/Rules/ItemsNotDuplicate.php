<?php

namespace Afaqy\Contract\Rules;

use Illuminate\Contracts\Validation\Rule;

class ItemsNotDuplicate implements Rule
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
        $items = array_count_values($value);

        foreach ($items as $item => $count) {
            if ($count > 1) {
                return false;
            }
        }

        return true;
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
