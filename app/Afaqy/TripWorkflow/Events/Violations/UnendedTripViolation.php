<?php

namespace Afaqy\TripWorkflow\Events\Violations;

use Illuminate\Queue\SerializesModels;

class UnendedTripViolation
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
    public $data;

    /**
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
            'violations',
            (new \ReflectionClass($this))->getShortName(),
            'trip:' . $this->data->id,
        ];
    }
}
