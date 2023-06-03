<?php

namespace Afaqy\TripWorkflow\DTO;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class AvlZoneData extends DataTransferObject
{
    /**
     * @var string
     */
    public $plate_number;

    /**
     * @var integer
     */
    public $zone_id;

    /**
     * @var int
     */
    public $shift_id;

    /**
     * @var int
     */
    public $enter_time;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self([
            'plate_number'  => $request->plate_number,
            'zone_id'       => $request->zone_id,
            'shift_id'      => $request->shift_id,
            'enter_time'    => Carbon::parse($request->enter_time)->getTimestamp(),
        ]);
    }
}
