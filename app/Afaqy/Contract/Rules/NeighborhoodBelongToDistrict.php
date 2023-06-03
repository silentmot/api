<?php

namespace Afaqy\Contract\Rules;

use Afaqy\District\Models\Neighborhood;
use Illuminate\Contracts\Validation\Rule;

class NeighborhoodBelongToDistrict implements Rule
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
        $attribute   = explode('.', $attribute);
        $district_id = request()->districts[$attribute[1]]['district_id'];

        return (bool) Neighborhood::where('id', $value)->where('district_id', $district_id)->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('contract::contract.neighborhood-not-belong-to-district');
    }
}
