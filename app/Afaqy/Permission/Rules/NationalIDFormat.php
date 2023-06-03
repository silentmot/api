<?php

namespace Afaqy\Permission\Rules;

use Illuminate\Contracts\Validation\Rule;

class NationalIDFormat implements Rule
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
        $pattern = '/^(1)|(2)([0-9]{9})$/';

        return (bool) preg_match($pattern, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('permission::permission.digit_start_with_one_or_two');
    }
}
