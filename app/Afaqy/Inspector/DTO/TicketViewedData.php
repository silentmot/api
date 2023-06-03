<?php

namespace Afaqy\Inspector\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class TicketViewedData extends DataTransferObject
{
    /** @var int */
    public $id;

    /** @var boolean */
    public $viewed;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self([
            'id'         => (int) $request->ticket,
            'viewed'     => true,
        ]);
    }
}
