<?php

namespace Afaqy\Contract\Rules;

use Carbon\Carbon;
use Afaqy\Unit\Models\Unit;
use Illuminate\Contracts\Validation\Rule;
use Afaqy\EntrancePermission\Models\EntrancePermission;

class UnitIdNotRelatedToActiveEntrancePermission implements Rule
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
        $unit  = Unit::find($value);

        $query = EntrancePermission::where('plate_number', $unit->plate_number)
            ->where('entrance_permissions.end_date', '>=', Carbon::now()->toDateString());

        if ($query->count()) {
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
        return trans('contract::contract.unit-has-entrance-permission');
    }
}
