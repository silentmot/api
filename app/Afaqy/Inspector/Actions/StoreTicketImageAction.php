<?php

namespace Afaqy\Inspector\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\Inspector\DTO\TicketData;
use Afaqy\Inspector\DTO\TicketImageData;

class StoreTicketImageAction extends Action
{
    /**
     * @var TicketData
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
        return $this->data->user->images()->create([
            'ticket_id' => $this->data->ticket->id,
            'url'       => $this->data->image,
        ]);
    }
}
