<?php

namespace Afaqy\District\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckNeighborhoodDuplication implements Rule
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
        $neighborhoods = request()->all()['neighborhoods'];
        $index         = (int) explode('.', $attribute)[1];

        foreach ($neighborhoods as $key => $neighborhood) {
            if ($key == $index) {
                continue;
            }

            if ($neighborhood['name'] == $value) {
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
        return trans('district::district.neighborhood-duplication-found');
    }
}
