<?php

namespace Afaqy\TripWorkflow\Rules;

use Carbon\Carbon;
use Afaqy\Device\Models\Device;
use Afaqy\TripWorkflow\Models\Trip;
use Illuminate\Contracts\Validation\Rule;

class DateBiggerThanLastOperation implements Rule
{
    /**
     * @var \Afaqy\Device\Models\Device
     */
    public $device;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->device = Device::where('ip', request()->device_ip)->first();

        if (!$this->device) {
            return true; // skip check, the error will appear in other validation
        }

        $trip = Trip::find(request()->trip_id);

        if (!$trip) {
            return true; // skip check, the error will appear in other validation
        }

        $weight_date = Carbon::parse($value);

        if ($this->device->direction == 'in') {
            $trip_date = Carbon::fromTimestamp($trip->start_time);

            return $weight_date->greaterThan($trip_date);
        }

        // for out

        if ($trip->enterance_weight_time) {
            $enterance_weight_time = Carbon::fromTimestamp($trip->enterance_weight_time);

            return $weight_date->greaterThan($enterance_weight_time);
        }

        $trip_date = Carbon::fromTimestamp($trip->start_time);

        return $weight_date->greaterThan($trip_date);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->device->direction == 'in') {
            return trans('tripworkflow::trip.escale-must-bigger-entrance');
        }

        return trans('tripworkflow::trip.xscale-must-bigger-entrance');
    }
}
