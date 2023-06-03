<?php

namespace Afaqy\Contractor\Rules;

use Illuminate\Contracts\Validation\Rule;

class TenDigitsNotStartedWithZero implements Rule
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
        $pattern = '/^(?!0)\d{10}$/';

        return (bool) preg_match($pattern, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('contractor::contractor.digit_start_with_zero');
    }
}
