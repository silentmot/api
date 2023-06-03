<?php

namespace Afaqy\TripWorkflow\Events\Success;

use Illuminate\Queue\SerializesModels;
use Afaqy\TripWorkflow\Helpers\PrepareEventsRequest;

class SuccessfullyGetAvlUnitInformation
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
    public $status = 'success';

    /**
     * @var string
     */
    public $client = 'avl';

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
     * @param int     $id
     * @param array   $request
     * @param object  $response
     * @param int     $order
     * @return void
     */
    public function __construct($id, $request, $response, $order = 3)
    {
        $this->log_id   = $id;
        $this->order    = $order;
        $this->request  = $this->getRequest($request);
        $this->response = $this->getResponse($response);
    }
}
