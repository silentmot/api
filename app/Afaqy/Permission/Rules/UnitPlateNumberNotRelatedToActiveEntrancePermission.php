<?php

namespace Afaqy\Permission\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Afaqy\EntrancePermission\Models\EntrancePermission;

class UnitPlateNumberNotRelatedToActiveEntrancePermission implements Rule
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
        $query = EntrancePermission::where('plate_number', $value)
            ->where('entrance_permissions.end_date', '>=', Carbon::now()->toDateString());

        if ($id = (int) request()->route('id')) {
            $query->where('entrance_permissions.id', '!=', $id);
        }

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
        return trans('permission::permission.unit-has-entrance-permission');
    }
}
