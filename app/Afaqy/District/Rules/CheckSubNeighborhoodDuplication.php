<?php

namespace Afaqy\District\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckSubNeighborhoodDuplication implements Rule
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
        return array_unique($value) == $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('district::district.sub-neighborhood-duplication-found');
    }
}
