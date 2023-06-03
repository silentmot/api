<?php

namespace Afaqy\Contract\Rules;

use Illuminate\Contracts\Validation\Rule;
use Afaqy\TransitionalStation\Models\TransitionalStation;

class StationBelongToDistricts implements Rule
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
        $districts = collect(request()->districts)->pluck('district_id')->all();

        return (bool) TransitionalStation::withDistricts()
            ->where('transitional_stations.id', $value)
            ->whereIn('districts.id', $districts)
            ->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('contract::contract.station-not-belong-to-district');
    }
}
