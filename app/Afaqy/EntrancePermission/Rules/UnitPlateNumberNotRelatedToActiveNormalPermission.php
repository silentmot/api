<?php

namespace Afaqy\EntrancePermission\Rules;

use Afaqy\TripWorkflow\Models\Trip;
use Afaqy\Permission\Models\PermitUnit;
use Illuminate\Contracts\Validation\Rule;

class UnitPlateNumberNotRelatedToActiveNormalPermission implements Rule
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
        $unit_permissions = PermitUnit::where('plate_number', $value)->get()->toArray();
        $permission_count = count($unit_permissions);

        if ($permission_count) {
            $trips_info_count =  Trip::where('trip_unit_type', 'permission')
                ->where('plate_number', $unit_permissions[0]['plate_number'])
                ->count();

            if ($trips_info_count != $permission_count) {
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
        return trans('permission::permission.unit-has-permission');
    }
}
