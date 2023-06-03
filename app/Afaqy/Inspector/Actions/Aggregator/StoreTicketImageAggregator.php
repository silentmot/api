<?php

namespace Afaqy\Inspector\Actions\Aggregator;

use Afaqy\Core\Actions\Aggregator;
use Illuminate\Support\Facades\DB;
use Afaqy\Inspector\DTO\TicketImageData;
use Afaqy\Core\Actions\Helpers\UploadFileAction;
use Afaqy\Inspector\Actions\StoreTicketImageAction;
use Afaqy\Inspector\Actions\UpdateTicketStatusAction;

class StoreTicketImageAggregator extends Aggregator
{
    /**
     * @var TicketImageData
     */
    private $data;

    /**
     * @param TicketImageData $data
     * @return void
     */
    public function __construct(TicketImageData $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $this->data->image = (new UploadFileAction($this->data->image, 'tickets'))->execute();

        DB::transaction(function () use (&$response) {
            $response = (new StoreTicketImageAction($this->data))->execute();

            if (request()->hasHeader('supervisor-id')) {
                (new UpdateTicketStatusAction($this->data->ticket->id, 'RESPONDED'))->execute();
            }
        });

        return $response;
    }
}
