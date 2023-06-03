<?php

namespace Afaqy\Permission\DTO;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class ProjectsPermissionData extends DataTransferObject
{
    /** @var int|null */
    public $id = null;

    /** @var int|null */
    public $demolition_serial;

    /** @var int */
    public $permission_number;

    /** @var string */
    public $permission_date;

    /** @var string */
    public $company_name;

    /** @var string */
    public $company_commercial_number;

    /** @var int|null */
    public $actual_weight;

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
            'id'                        => $id ?? null,
            'demolition_serial'         => (int) $request->input('demolition_serial') ?? null,
            'permission_number'         => (int) $request->input('permission_number'),
            'permission_date'           => Carbon::parse($request->input('permission_date'))->format('Y-m-d'),
            'company_name'              => $request->input('company_name'),
            'company_commercial_number' => $request->input('company_commercial_number'),
            'actual_weight'             => $request->input('actual_weight') ?? null,
            'units'                     => $request->units,
        ]);
    }
}
