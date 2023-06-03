<?php

namespace Afaqy\Permission\Rules;

use Carbon\Carbon;
use Afaqy\Unit\Models\Unit;
use Illuminate\Contracts\Validation\Rule;

class UnitPlateNumberNotRelatedToActiveContract implements Rule
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
        $contractedUnitWithDistrict = Unit::whereContractsActive()
            ->where('active', 1)
            ->where('plate_number', $value)
            ->count();

        if ($contractedUnitWithDistrict) {
            return false;
        }

        $contractedUnitWithStation = Unit::WithStationContracts()
            ->whereNull('contracts.deleted_at')
            ->where('contracts.status', '=', 1)
            ->where('contracts.end_at', '>=', Carbon::now()->toDateString())
            ->where('units.active', 1)
            ->where('plate_number', $value)->count();

        if ($contractedUnitWithStation) {
            return false;
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
        return trans('permission::permission.units-contracted');
    }
}
