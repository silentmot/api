<?php

namespace Afaqy\TripWorkflow\Listeners\Violations;

use Illuminate\Contracts\Queue\ShouldQueue;
use Afaqy\TripWorkflow\Models\TripUnitInformation;
use Afaqy\TripWorkflow\Events\Violations\UnitMaxWeightViolation;

class CheckMaxWeightViolation implements ShouldQueue
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

        if ($unit_info->max_weight < $event->trip->enterance_weight) {
            event(new UnitMaxWeightViolation($event->log_id, $event->trip, $event->order));
        }

        return true;
    }
}
