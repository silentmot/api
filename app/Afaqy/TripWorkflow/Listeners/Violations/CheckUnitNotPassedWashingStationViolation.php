<?php

namespace Afaqy\TripWorkflow\Listeners\Violations;

use Illuminate\Contracts\Queue\ShouldQueue;

class CheckUnitNotPassedWashingStationViolation implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        return true;
    }
}
