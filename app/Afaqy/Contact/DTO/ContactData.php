<?php

namespace Afaqy\Contact\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class ContactData extends FlexibleDataTransferObject
{
    /** @var int|null */
    public $id = null;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string|null
     */
    public $title= null;

    /**
     * @var string|null
     */
    public $email = null;

    /**
     * @var bool
     */
    public $default_contact = false;

    /**
     * @var array
     */
    public $phones;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int|null $id
     * @return self
     */
    public static function fromRequest(Request $request, ?int $id = null): self
    {
        return new self([
            'id'                => $id ?? null,
            'name'              => $request->name,
            'title'             => $request->title ?? null,
            'email'             => $request->email ?? null,
            'default_contact'   => $request->default_contact ?? false,
            'phones'            => $request->phones,
        ]);
    }
}
