<?php

namespace Afaqy\TripWorkflow\Events;

use Illuminate\Queue\SerializesModels;

class TripStarted
{
    use SerializesModels;

    /**
     * @var int
     */
    public $log_id;

    /**
     * @var int
     */
    public $order = 3;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @param int                                 $id
     * @param \Illuminate\Database\Eloquent\Model $data
     * @return void
     */
    public function __construct($id, $data)
    {
        $this->log_id = $id;
        $this->data   = $data;
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
            'trip:' . $this->data->id,
        ];
    }
}
