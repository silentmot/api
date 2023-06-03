<?php

namespace Afaqy\District\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class NeighborhoodData extends FlexibleDataTransferObject
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
     * @var int|null
     */
    public $population;

    /**
     * @var boolean
     */
    public $status;

    /**
     * @var array
     */
    public $neighborhood_points;

    /**
     * @var array
     */
    public $sub_neighborhoods;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self([
            'id'                  => $request->id ?? null,
            'name'                => $request->name,
            'population'          => $request->population ?? null,
            'status'              => (bool) $request->status,
            'neighborhood_points' => $request->neighborhood_points ?? null,
            'sub_neighborhoods'   => $request->sub_neighborhoods,
        ]);
    }
}
