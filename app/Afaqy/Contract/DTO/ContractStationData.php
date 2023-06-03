<?php

namespace Afaqy\Contract\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class ContractStationData extends FlexibleDataTransferObject
{
    /** @var int */
    public $station_id;

    /** @var array */
    public $units_ids;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self([
            'station_id' => $request->district_id,
            'units_ids'  => $request->units_ids,
        ]);
    }
}
