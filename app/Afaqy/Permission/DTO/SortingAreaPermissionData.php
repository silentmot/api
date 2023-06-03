<?php

namespace Afaqy\Permission\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class SortingAreaPermissionData extends DataTransferObject
{
    /** @var int|null */
    public $id = null;

    /** @var int */
    public $waste_type_id;

    /** @var string */
    public $entity_name;

    /** @var string|null */
    public $representative_name;

    /** @var int|null */
    public $national_id;

    /** @var int|null */
    public $allowed_weight;

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
    public static function fromRequest(Request $request): self
    {
        return new self([
            'id'                        => $id ?? null,
            'waste_type_id'             => $request->waste_type_id,
            'allowed_weight'            => $request->allowed_weight,
            'entity_name'               => $request->entity_name,
            'representative_name'       => $request->representative_name ?? null,
            'national_id'               => $request->national_id ?? null,
            'actual_weight'             => $request->actual_weight ?? null,
            'units'                     => $request->units,
        ]);
    }
}
