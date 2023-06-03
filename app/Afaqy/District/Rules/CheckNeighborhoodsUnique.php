<?php

namespace Afaqy\District\Rules;

use Afaqy\District\Models\Neighborhood;
use Illuminate\Contracts\Validation\Rule;

class CheckNeighborhoodsUnique implements Rule
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
        $result = true;

        foreach ($value as $key => $neighborhood) {
            $db_neighborhood = Neighborhood::where('district_id', request()->id)->where('name', $neighborhood['name'])->first();

            if (is_null($db_neighborhood)) {
                continue;
            }

            $neighborhood_id = $neighborhood['id'] ?? 0;

            if ($db_neighborhood->id != $neighborhood_id) {
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
        return trans('district::district.neighborhood-not-unique');
    }
}
