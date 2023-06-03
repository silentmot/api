<?php

namespace Afaqy\TripWorkflow\Events\Violations;

use Illuminate\Queue\SerializesModels;

class UnitHasNotEntranceWeightViolation
{
    use SerializesModels;

    /**
     * @var int
     */
    public $log_id;

    /**
     * @var int
     */
    public $order;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $data;

    /**
     * @param int                                 $id
     * @param \Illuminate\Database\Eloquent\Model $data
     * @param int                                 $order
     * @return void
     */
    public function __construct($id, $data, $order = 2)
    {
        $this->log_id = $id;
        $this->data   = $data;
        $this->order  = $order;
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
