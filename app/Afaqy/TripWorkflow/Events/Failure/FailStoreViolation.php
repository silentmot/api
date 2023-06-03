<?php

namespace Afaqy\TripWorkflow\Events\Failure;

use Illuminate\Queue\SerializesModels;
use Afaqy\TripWorkflow\Helpers\PrepareEventsRequest;

class FailStoreViolation
{
    use SerializesModels;
    use PrepareEventsRequest;

    /**
     * @var int
     */
    public $log_id;

    /**
     * @var int
     */
    public $order;

    /**
     * @var string
     */
    public $status = 'fail';

    /**
     * @var string
     */
    public $client = 'slf-client';

    /**
     * @var array
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @param int     $id
     * @param array   $data
     * @param int     $order
     * @return void
     */
    public function __construct($id, $data, $order)
    {
        $this->log_id = $id;
        $this->data   = $data;
        $this->order  = $order;
    }
}
