<?php

namespace Afaqy\Contract\Rules;

use Afaqy\Unit\Models\Unit;
use Afaqy\TripWorkflow\Models\Trip;
use Afaqy\Permission\Models\PermitUnit;
use Illuminate\Contracts\Validation\Rule;

class UnitIdNotRelatedToActiveNormalPermission implements Rule
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
        $unit = Unit::find($value);

        $unit_count_in_permissions  = PermitUnit::where('plate_number', $unit->plate_number)->count();

        if ($unit_count_in_permissions) {
            $trips_info_count = Trip::where('trip_unit_type', 'permission')
                ->where('plate_number', $unit->plate_number)
                ->count();

            if ($trips_info_count != $unit_count_in_permissions) {
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
        return trans('contract::contract.unit-has-permission');
    }
}
