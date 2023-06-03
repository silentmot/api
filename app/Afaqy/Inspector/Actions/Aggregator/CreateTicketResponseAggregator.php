<?php

namespace Afaqy\Inspector\Actions\Aggregator;

use Afaqy\Core\Actions\Aggregator;
use Illuminate\Support\Facades\DB;
use Afaqy\Inspector\DTO\TicketResponseData;
use Afaqy\Inspector\Actions\UpdateTicketStatusAction;
use Afaqy\Inspector\Actions\StoreTicketResponseAction;

class CreateTicketResponseAggregator extends Aggregator
{
    /**
     * @var \Afaqy\Inspector\DTO\TicketResponseData
     */
    private $data;

    /**
     * @param \Afaqy\Inspector\DTO\TicketResponseData $data
     * @return void
     */
    public function __construct(TicketResponseData $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        DB::transaction(function () use (&$response) {
            $response = (new StoreTicketResponseAction($this->data))->execute();

            if (request()->hasHeader('supervisor-id')) {
                return (new UpdateTicketStatusAction($this->data->ticket->id, 'RESPONDED'))->execute();
            }

            return (new UpdateTicketStatusAction($this->data->ticket->id, 'PENALTY'))->execute();
        });

        return $response;
    }
}
