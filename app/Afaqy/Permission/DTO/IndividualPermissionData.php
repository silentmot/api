<?php

namespace Afaqy\Permission\DTO;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class IndividualPermissionData extends FlexibleDataTransferObject
{
    /** @var int|null */
    public $id = null;

    /** @var int|null */
    public $demolition_serial;

    /** @var int */
    public $permission_number;

    /** @var string */
    public $type;

    /** @var string */
    public $permission_date;

    /** @var int */
    public $district_id;

    /** @var int */
    public $neighborhood_id;

    /** @var string|null */
    public $street;

    /** @var string */
    public $owner_name;

    /** @var int */
    public $owner_phone;

    /** @var int */
    public $national_id;

    /**
     * @var \Afaqy\Permission\DTO\UnitData[]
     */
    public $units;

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
            'demolition_serial'  => (int) $request->input('demolition_serial') ?? null,
            'permission_number'  => (int) $request->input('permission_number'),
            'type'               => $request->input('type'),
            'permission_date'    => Carbon::parse($request->input('permission_date'))->format('Y-m-d'),
            'district_id'        => $request->input('district_id'),
            'neighborhood_id'    => $request->input('neighborhood_id'),
            'owner_name'         => $request->input('owner_name'),
            'owner_phone'        => (int) $request->input('owner_phone'),
            'street'             => $request->input('street') ?? null,
            'national_id'        => $request->input('national_id'),
            'units'              => $request->units,

        ]);
    }
}
