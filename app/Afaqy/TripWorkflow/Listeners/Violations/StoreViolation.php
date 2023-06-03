<?php

namespace Afaqy\TripWorkflow\Listeners\Violations;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Afaqy\TripWorkflow\Models\TripViolation;
use Afaqy\TripWorkflow\Events\Failure\FailStoreViolation;
use Afaqy\TripWorkflow\Events\Success\SuccessfullyStoredViolation;

class StoreViolation implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $data = [
            'trip_id'        => $event->data->id,
            'plate_number'   => $event->data->plate_number,
            'violation_type' => (new \ReflectionClass($event))->getShortName(),
            'violation_time' => Carbon::now()->getTimestamp(),
        ];

        $violation = TripViolation::create($data);

        if ($violation) {
            event(new SuccessfullyStoredViolation($event->log_id, $data, $event->order));

            return true;
        }

        event(new FailStoreViolation($event->log_id, $data, $event->order));
    }
}
