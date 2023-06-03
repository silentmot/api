<?php

namespace Afaqy\Inspector\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\Inspector\Models\Ticket;

class UpdateTicketStatusAction extends Action
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $status;

    /**
     * @param int $id
     * @param string $status
     * @return void
     */
    public function __construct(int $id, string $status)
    {
        $this->id     = $id;
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return Ticket::where('id', $this->id)->update([
            'status' => $this->status,
        ]);
    }
}
