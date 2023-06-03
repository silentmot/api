<?php

namespace Afaqy\Geofence\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class GeofenceData extends DataTransferObject
{
    /** @var int|null */
    public $id = null;

    /** @var string */
    public $name;

    /** @var string */
    public $type;

    /** @var int */
    public $geofence_id;

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
            'name'        => $request->input('name'),
            'type'        => $request->input('type'),
            'geofence_id' => $request->input('geofence_id'),
        ]);
    }
}
