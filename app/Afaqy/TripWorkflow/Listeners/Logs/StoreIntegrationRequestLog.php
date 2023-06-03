<?php

namespace Afaqy\TripWorkflow\Listeners\Logs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Afaqy\TripWorkflow\Models\IntegrationLog;

class StoreIntegrationRequestLog implements ShouldQueue
{
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
        IntegrationLog::create([
            'log_id'     => $event->log_id ?? null,
            'log_order'  => $event->order ?? 0,
            'status'     => $event->status ?? null,
            'event_name' => (new \ReflectionClass($event))->getShortName(),
            'client'     => $event->client ?? null,
            'data'       => json_encode($event->data ?? []),
            'request'    => json_encode($event->request ?? []),
            'response'   => json_encode($event->response ?? []),
        ]);
    }
}
