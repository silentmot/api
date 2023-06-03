<?php

namespace Afaqy\TripWorkflow\Emails;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnitMaxWeightEmail extends Mailable implements ShouldQueue
{
    use SerializesModels;

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'low';

    /**
     * @var \Afaqy\Dashboard\Models\Dashboard
     */
    public $trip;

    /**
     * @var \Afaqy\User\Models\User
     */
    public $user;

    /**
     * @var string
     */
    public $event_name;

    /**
     * @param \Afaqy\Dashboard\Models\Dashboard $trip
     * @param \Afaqy\User\Models\User $user
     * @param string $event_name
     * @return void
     */
    public function __construct($trip, $user, $event_name)
    {
        $this->trip       = $trip;
        $this->user       = $user;
        $this->event_name = $event_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('تنبيه بالحمولة القصوى')->markdown('tripworkflow::emails.max_weight');
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags()
    {
        return [
            'notifications',
            'violations',
            $this->event_name,
            'trip:' . $this->trip->id,
        ];
    }
}
