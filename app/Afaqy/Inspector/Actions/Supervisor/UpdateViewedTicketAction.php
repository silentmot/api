<?php

namespace Afaqy\Inspector\Actions\Supervisor;

use Afaqy\Core\Actions\Action;
use Afaqy\Inspector\Models\Ticket;

class UpdateViewedTicketAction extends Action
{
    /**
     * @var int
     */
    private $id;

    /**
     * @param int $data
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return Ticket::where('id', $this->id)->whereNotIn('status', ['PENDING', 'RESPONDED'])->update([
            'is_viewed' => true,
        ]);
    }
}
