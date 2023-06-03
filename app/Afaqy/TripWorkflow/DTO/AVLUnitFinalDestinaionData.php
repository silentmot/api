<?php

namespace Afaqy\TripWorkflow\DTO;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class AVLUnitFinalDestinaionData extends DataTransferObject
{
    /**
     * @var string
     */
    public $plate_number;

    /**
     * @var int
     */
    public $shift_id;

    /**
     * @var int
     */
    public $arrival_time;

    /**
     * @var string
     */
    public $arrival_location;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self([
            'plate_number'     => $request->plate_number,
            'shift_id'         => $request->shift_id,
            'arrival_time'     => Carbon::parse($request->arrival_time)->getTimestamp(),
            'arrival_location' => $request->arrival_location,
        ]);
    }
}
