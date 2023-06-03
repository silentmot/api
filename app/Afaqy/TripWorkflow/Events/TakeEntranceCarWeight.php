<?php

namespace Afaqy\TripWorkflow\Events;

use Illuminate\Queue\SerializesModels;

class TakeEntranceCarWeight
{
    use SerializesModels;

    /**
     * @var int
     */
    public $log_id;

    /**
     * @var int
     */
    public $order = 2;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $trip;

    /**
     * Create a new event instance.
     *
     * @param int                                 $id
     * @param \Illuminate\Database\Eloquent\Model $trip
     * @return void
     */
    public function __construct($id, $trip)
    {
        $this->log_id = $id;
        $this->trip   = $trip;
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags()
    {
        return [
            (new \ReflectionClass($this))->getShortName(),
            'trip:' . $this->trip->id,
        ];
    }
}
