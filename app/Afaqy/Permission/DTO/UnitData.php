<?php

namespace Afaqy\Permission\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class UnitData extends FlexibleDataTransferObject
{
    /** @var string */
    public $plate_number;

    /** @var int|null */
    public $rfid = null;

    /** @var int|null */
    public $qr_code = null;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return self
     */
    public static function fromRequest(Request $request, ? int $serial = null) : self
    {
        return new self([
            'plate_number' => $request->plate_number,
            'rfid'         => $request->rfid ?? null,
            'qr_code'      => $request->qr_code ?? null,
        ]);
    }
}
