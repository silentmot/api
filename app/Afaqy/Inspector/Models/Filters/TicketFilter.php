<?php

namespace Afaqy\Inspector\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class TicketFilter extends ModelFilter
{
    /**
     * @param $status
     * @return TicketFilter
     */
    public function status($status)
    {
        return $this->whereIn('mob_inspector_tickets.status', $status);
    }
}
