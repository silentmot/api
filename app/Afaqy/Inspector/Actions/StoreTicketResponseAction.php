<?php

namespace Afaqy\Inspector\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\Inspector\DTO\TicketResponseData;

class StoreTicketResponseAction extends Action
{
    /**
     * @var TicketResponseData
     */
    private $data;

    /**
     * @param TicketResponseData $data
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
        if ($this->isTicketHasResponse($this->data->ticket->id)) {
            return true;
        }

        return $this->data->user->responses()->create([
            'ticket_id' => $this->data->ticket->id,
            'details'   => $this->data->details,
        ]);
    }

    /**
     * @param int $ticket_id
     * @return boolean
     */
    private function isTicketHasResponse(int $ticket_id): bool
    {
        return $this->data->user->responses()->where('ticket_id', $ticket_id)->count();
    }
}
