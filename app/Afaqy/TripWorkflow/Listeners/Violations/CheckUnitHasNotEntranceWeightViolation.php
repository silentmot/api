<?php

namespace Afaqy\TripWorkflow\Listeners\Violations;

use Illuminate\Contracts\Queue\ShouldQueue;
use Afaqy\TripWorkflow\Events\Violations\UnitHasNotEntranceWeightViolation;

class CheckUnitHasNotEntranceWeightViolation implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->trip->enterance_weight) {
            return true;
        }

        event(new UnitHasNotEntranceWeightViolation($event->log_id, $event->trip, $event->order));
    }
}
