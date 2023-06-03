<?php

namespace Afaqy\Contractor\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckSingleDefaultContact implements Rule
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
        $counter = 0;

        $contacts = request('contacts');
        foreach ($contacts as $contact) {
            if ($contact['default_contact'] == true) {
                $counter++;
            }
        }

        return ($counter == 1) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('contractor::contractor.validation_default_contact');
    }
}
