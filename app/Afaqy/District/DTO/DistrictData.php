<?php

namespace Afaqy\District\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class DistrictData extends FlexibleDataTransferObject
{
    /**
     * @var int|null
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var boolean
     */
    public $status;

    /**
     * @var array
     */
    public $points;

    /**
     * @var \Afaqy\District\DTO\NeighborhoodData[]
     */
    public $neighborhoods;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int|null                 $id
     * @return self
     */
    public static function fromRequest(Request $request, ? int $id = null) : self
    {
        return new self([
            'id'            => $id,
            'name'          => $request->name,
            'status'        => (bool) $request->status,
            'points'        => $request->points ?? null,
            'neighborhoods' => $request->neighborhoods,
        ]);
    }
}
