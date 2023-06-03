<?php

namespace Afaqy\TripWorkflow\Events\Success;

use Illuminate\Queue\SerializesModels;
use Afaqy\TripWorkflow\Helpers\PrepareEventsRequest;

class SuccessfullyStoredUnitFinalDestination
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
     * @return void
     */
    public function __construct($id, $request, $response)
    {
        $this->log_id   = $id;
        $this->request  = $this->getRequest($request);
        $this->response = $this->getResponse($response);
    }
}
