<?php

namespace Afaqy\Contractor\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailFormat implements Rule
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
        $pattern = '/^[A-Za-z0-9\.\-\_]+@[A-Za-z0-9\-\_]+(?:\.[A-Za-z]+)+$/';

        return (bool) preg_match($pattern, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('contractor::contractor.validation_email');
    }
}
