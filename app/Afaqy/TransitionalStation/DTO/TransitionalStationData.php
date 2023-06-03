<?php

namespace Afaqy\TransitionalStation\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class TransitionalStationData extends FlexibleDataTransferObject
{
    /** @var int|null */
    public $id = null;

    /** @var string */
    public $name;

    /** @var int */
    public $status;

    /**
     * @var array
     */
    public $districts = [];

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
            'id'          => $id ?? null,
            'name'        => $request->name,
            'status'      => $request->status,
            'districts'   => $request->districts,
        ]);
    }
}
