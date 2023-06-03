<?php

namespace Afaqy\Contract\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class ContractDistrictData extends FlexibleDataTransferObject
{
    /** @var int */
    public $district_id;

    /** @var int */
    public $neighborhood_id;

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
            'district_id'     => $request->district_id,
            'neighborhood_id' => $request->neighborhood_id,
            'units_ids'       => $request->units_ids,
        ]);
    }
}
