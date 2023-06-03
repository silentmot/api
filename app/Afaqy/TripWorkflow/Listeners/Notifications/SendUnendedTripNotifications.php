<?php

namespace Afaqy\TripWorkflow\Listeners\Notifications;

use Illuminate\Contracts\Queue\ShouldQueue;
use Afaqy\TripWorkflow\Emails\UnendedTripEmail;

class SendUnendedTripNotifications implements ShouldQueue
{
    use HandleNotifications;

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'low';

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        return $this->sendNotification($event, UnendedTripEmail::class);
    }
}
