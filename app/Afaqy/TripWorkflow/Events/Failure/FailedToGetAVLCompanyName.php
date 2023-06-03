<?php

namespace Afaqy\TripWorkflow\Events\Failure;

use Illuminate\Queue\SerializesModels;
use Afaqy\TripWorkflow\Helpers\PrepareEventsRequest;

class FailedToGetAVLCompanyName
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
    public $client = 'avl';

    /**
     * Create a new event instance.
     *
     * @param int $id
     * @param int $order
     * @return void
     */
    public function __construct($id, $order = 3)
    {
        $this->log_id = $id;
        $this->order  = $order;
    }
}
