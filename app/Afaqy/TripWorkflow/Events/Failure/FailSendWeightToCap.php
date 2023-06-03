<?php

namespace Afaqy\TripWorkflow\Events\Failure;

use Illuminate\Queue\SerializesModels;
use Afaqy\TripWorkflow\Helpers\PrepareEventsRequest;

class FailSendWeightToCap
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
    public $order = 1;

    /**
     * @var string
     */
    public $status = 'fail';

    /**
     * @var string
     */
    public $client = 'cap';

    /**
     * @var array
     */
    public $request;

    /**
     * @var array
     */
    public $response;

    /**
     * Create a new event instance.
     *
     * @param int   $id
     * @param mixed $request
     * @param mixed $response
     * @param int   $order
     * @return void
     */
    public function __construct($id, $request, $response, $order = 2)
    {
        $this->log_id   = $id;
        $this->order    = $order;
        $this->request  = $this->getRequest($request);
        $this->response = $this->getResponse($response);
    }
}
