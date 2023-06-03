<?php

namespace Afaqy\WasteType\DTO;

use Illuminate\Http\Request;
use Afaqy\WasteType\Models\WasteType;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class WasteTypeData extends FlexibleDataTransferObject
{
    /** @var int|null */
    public $id = null;

    /** @var string */
    public $name;

    /** @var int|null */
    public $zone_id = null;

    /** @var int|null */
    public $pit_id = null;

    /**
     * @var array
     */
    public $scale_zones = [];

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
            $wasteType = WasteType::findOrFail($id);
        }

        return new self([
            'id'          => $id ?? null,
            'name'        => $request->name ?? $wasteType->name,
            'zone_id'     => $request->zone_id,
            'pit_id'      => $request->pit_id,
            'scale_zones' => $request->scale_zones,
        ]);
    }
}
