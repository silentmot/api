<?php

namespace Afaqy\Inspector\DTO;

use Afaqy\User\Models\User;
use Illuminate\Http\Request;
use Afaqy\Contact\Models\Contact;
use Afaqy\Inspector\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\DataTransferObject;

class TicketImageData extends DataTransferObject
{
    /**
     * @var Afaqy\Inspector\Models\Ticket
     */
    public $ticket;

    /** @var mixed */
    public $image;

    /** @var mixed */
    public $user;

    /**
     * @param Request $request
     * @param int $id
     * @return static
     */
    public static function fromRequest(Request $request, int $id): self
    {
        // @TODO: can upload image even after ticket is accept
        $ticket = Ticket::findOrFail($id);

        $user = $request->hasHeader('supervisor-id')
            ? Contact::findOrFail(auth()->id())
            : User::findOrFail(auth()->id());

        return new self([
            'ticket' => $ticket,
            'user'   => $user,
            'image'  => $request->file('image'),
        ]);
    }
}
