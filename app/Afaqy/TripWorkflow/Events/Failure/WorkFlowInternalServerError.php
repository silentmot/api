<?php

namespace Afaqy\TripWorkflow\Events\Failure;

use Illuminate\Queue\SerializesModels;
use Afaqy\TripWorkflow\Helpers\PrepareEventsRequest;

class WorkFlowInternalServerError
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
    public $order = 100;

    /**
     * @var string
     */
    public $status = 'fail';

    /**
     * @var string
     */
    public $client = 'server';

    /**
     * @var array
     */
    public $request;

    /**
     * @var array
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @param int $id
     * @param array      $request
     * @param \Exception $exception
     * @return void
     */
    public function __construct($id, $request, $exception)
    {
        $this->log_id  = $id;
        $this->request = $this->getRequest($request);
        $this->data    = $this->getException($exception);
    }
}
