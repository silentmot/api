<?php

namespace Afaqy\TripWorkflow\Rules;

use Afaqy\Zone\Models\Zone;
use Afaqy\Scale\Models\Scale;
use Illuminate\Contracts\Validation\Rule;

class DeviceIpBelongToSameScaleZone implements Rule
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
        $zone = Zone::withDevices()
            ->select('zones.id')
            ->where('ip', $value)
            ->whereIn('zones.type', ['entranceScale', 'exit'])
            ->first();

        if (is_null($zone)) {
            return false;
        }

        $scale = Scale::select('zone_id')
            ->where('ip', request()->scale_ip)
            ->where('zone_id', $zone->id)
            ->first();

        if (is_null($scale)) {
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
        return trans('tripworkflow::trip.device-not-belong-zone');
    }
}
