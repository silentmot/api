<?php

namespace Afaqy\TripWorkflow\Listeners\Violations;

use Illuminate\Contracts\Queue\ShouldQueue;
use Afaqy\TripWorkflow\Models\TripUnitInformation;
use Afaqy\TripWorkflow\Events\Violations\UnitExceedNetWeightViolation;

class CheckUnitExceedNetWeightViolation implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->trip->trip_unit_type == 'permission') {
            return true;
        }

        $unit_info = TripUnitInformation::where('trip_id', $event->trip->id)->first();

        if (!$unit_info->net_weight) {
            return true;
        }

        if ($event->trip->exit_weight >= $event->trip->enterance_weight) {
            return true;
        }

        $max_net_weight = $unit_info->net_weight + ($unit_info->net_weight * 10 / 100);

        if ($event->trip->exit_weight > $max_net_weight) {
            event(new UnitExceedNetWeightViolation($event->log_id, $event->trip, $event->order));
        }

        return true;
    }
}
