<?php

namespace Afaqy\TripWorkflow\Listeners\Violations;

use Illuminate\Contracts\Queue\ShouldQueue;
use Afaqy\TripWorkflow\Models\TripUnitInformation;
use Afaqy\TripWorkflow\Events\Violations\UnitUnloadedViolation;

class CheckUnitUnloadedViolation implements ShouldQueue
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
            $unit = TripUnitInformation::select(['permission_type'])
                ->where('trip_id', $event->trip->id)
                ->first();

            if ($unit->permission_type == 'sorting') {
                return true;
            }
        }

        if (is_null($event->trip->enterance_weight)) {
            return true;
        }

        if ($event->trip->exit_weight < $event->trip->enterance_weight) {
            return true;
        }

        event(new UnitUnloadedViolation($event->log_id, $event->trip, $event->order));

        return true;
    }
}
