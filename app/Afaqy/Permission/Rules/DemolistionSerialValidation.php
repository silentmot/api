<?php

namespace Afaqy\Permission\Rules;

use Illuminate\Contracts\Validation\Rule;

class DemolistionSerialValidation implements Rule
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
        $pattern = '/^([0-9]{8})$/';

        return (bool) preg_match($pattern, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('permission::permission.demolition_serial_validation');
    }
}
