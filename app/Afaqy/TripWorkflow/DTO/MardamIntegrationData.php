<?php

namespace Afaqy\TripWorkflow\DTO;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class MardamIntegrationData extends DataTransferObject
{
    /** @var string */
    public $plate_number;

    /** @var int */
    public $total_weight;

    /** @var \Carbon\Carbon */
    public $create_date;

    /** @var string */
    public $operation_type;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self([
            'plate_number'   => $request->plate_number,
            'total_weight'   => $request->total_weight,
            'create_date'    => Carbon::parse($request->create_date),
            'operation_type' => $request->operation_type,
        ]);
    }
}
