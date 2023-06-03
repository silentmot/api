<?php

namespace Afaqy\UnitType\DTO;

use Illuminate\Http\Request;
use Afaqy\UnitType\Models\UnitType;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class UnitTypeData extends FlexibleDataTransferObject
{
    /** @var int|null */
    public $id = null;

    /** @var string */
    public $name;

    /**
     * @var array
     */
    public $waste_types = [];

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int|null $id
     * @return self
     */
    public static function fromRequest(Request $request, ?int $id = null): self
    {
        if ($id) {
            $unitType = UnitType::findOrFail($id);
        }

        return new self([
            'id'          => $id ?? null,
            'name'        => $request->input('name') ?? $unitType->name,
            'waste_types' => $request->input('waste_types'),
        ]);
    }
}
