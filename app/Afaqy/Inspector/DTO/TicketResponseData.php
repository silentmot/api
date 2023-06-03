<?php

namespace Afaqy\Inspector\DTO;

use Afaqy\User\Models\User;
use Illuminate\Http\Request;
use Afaqy\Contact\Models\Contact;
use Afaqy\Inspector\Models\Ticket;
use Spatie\DataTransferObject\DataTransferObject;

class TicketResponseData extends DataTransferObject
{
    /**
     * @var Afaqy\Inspector\Models\Ticket
     */
    public $ticket;

    /** @var string|null */
    public $details;

    /** @var mixed */
    public $user;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param Request $request
     * @param int $id
     * @return self
     */
    public static function fromRequest(Request $request, int $id): self
    {
        $ticket = Ticket::findOrFail($id);

        $user = $request->hasHeader('supervisor-id')
            ? Contact::findOrFail(auth()->id())
            : User::findOrFail(auth()->id());

        return new self([
            'ticket'  => $ticket,
            'user'    => $user,
            'details' => $request->details,
        ]);
    }
}
