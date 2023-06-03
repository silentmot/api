<?php

namespace Afaqy\Contract\Rules;

use Carbon\Carbon;
use Afaqy\Unit\Models\Unit;
use Illuminate\Contracts\Validation\Rule;

class UnitIdNotRelatedToActiveContract implements Rule
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
        $id = (int) request()->route('id');

        $query = Unit::whereContractsActive()
            ->where('active', 1)
            ->where('units.id', $value);

        if ($id) {
            $query->where('contracts.id', '!=', $id);
        }

        if ($query->count()) {
            return false;
        }

        $query = Unit::WithStationContracts()
            ->whereNull('contracts.deleted_at')
            ->where('contracts.status', '=', 1)
            ->where('contracts.end_at', '>=', Carbon::now()->toDateString())
            ->where('units.active', 1)
            ->where('units.id', $value);

        if ($id) {
            $query->where('contracts.id', '!=', $id);
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
        return trans('contract::contract.units-unContracted');
    }
}
