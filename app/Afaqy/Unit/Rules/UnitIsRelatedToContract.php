<?php

namespace Afaqy\Unit\Rules;

use Carbon\Carbon;
use Afaqy\Unit\Models\Unit;
use Illuminate\Contracts\Validation\Rule;

class UnitIsRelatedToContract implements Rule
{
    /**
     * @var int
     */
    protected $unit_id;

    /**
     * @param int $unit_id
     * @return void
     */
    public function __construct($unit_id)
    {
        $this->unit_id = $unit_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return boolean
     */
    public function passes($attribute, $contractor_id)
    {
        $unit = Unit::findOrFail($this->unit_id);

        // if same old contractor value pass the check and return true
        if ($unit->contractor_id != $contractor_id) {
            if ($this->hasActiceContract($unit->id)) {
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
        return trans('unit::unit.contractor_related_to_contract');
    }

    /**
     * @param  int  $unit_id
     * @return boolean
     */
    private function hasActiceContract($unit_id): bool
    {
        $date = Carbon::now()->toDateString();

        return (bool) Unit::withContracts()
            ->where('units.id', $unit_id)
            ->where('contracts.status', 1)
            ->where('contracts.start_at', '<=', $date)
            ->where('contracts.end_at', '>=', $date)
            ->whereNull('contracts.deleted_at')
            ->count();
    }
}
