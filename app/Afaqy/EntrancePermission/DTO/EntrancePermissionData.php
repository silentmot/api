<?php

namespace Afaqy\EntrancePermission\DTO;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class EntrancePermissionData extends DataTransferObject
{
    /** @var int|null */
    public $id = null;

    /** @var string*/
    public $type = null;

    /** @var string*/
    public $name = null;

    /** @var string*/
    public $title = null;

    /** @var int*/
    public $national_id = null;

    /** @var string*/
    public $phone = null;

    /** @var string|null*/
    public $company = null;

    /** @var string*/
    public $plate_number = null;

    /** @var string*/
    public $start_date = null;

    /** @var string*/
    public $end_date = null;

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
    public static function fromRequest(Request $request, ?int $id = null): self
    {
        return new self([
            'id'                 => $id ?? null,
            'type'               => $request->input('type'),
            'name'               => $request->input('name'),
            'title'              => $request->input('title'),
            'national_id'        => $request->input('national_id'),
            'phone'              => $request->input('phone'),
            'company'            => $request->input('company') ?? null,
            'plate_number'       => $request->input('plate_number') ?? null,
            'start_date'         => Carbon::parse($request->input('start_date'))->format('Y-m-d'),
            'end_date'           => Carbon::parse($request->input('end_date'))->format('Y-m-d'),
            "rfid"               => $request->rfid ?? null,
            "qr_code"            => $request->qr_code ?? null,
        ]);
    }
}
