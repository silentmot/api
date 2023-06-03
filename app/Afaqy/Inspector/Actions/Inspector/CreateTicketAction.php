<?php

namespace Afaqy\Inspector\Actions\Inspector;

use Afaqy\Core\Actions\Action;
use Afaqy\Inspector\Models\Ticket;
use Afaqy\Inspector\DTO\TicketData;

class CreateTicketAction extends Action
{
    /**
     * @var TicketData
     */
    private $data;

    /**
     * @param TicketData $data
     * @return void
     */
    public function __construct(TicketData $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return Ticket::create($this->data->toArray());
    }
}
