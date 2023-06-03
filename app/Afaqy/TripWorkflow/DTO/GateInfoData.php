<?php

namespace Afaqy\TripWorkflow\DTO;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class GateInfoData extends DataTransferObject
{
    /**
     * @var int|null
     */
    public $trip_id = null;

    /**
     * @var string|null
     */
    public $plate_number = null;

    /**
     * @var string|null
     */
    public $gate_ip = null;

    /**
     * @var string|null
     */
    public $gate_time= null;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self([
            'trip_id'       => $request->trip_id,
            'plate_number'  => $request->plate_number,
            'gate_ip'       => $request->gate_ip,
            'gate_time'     => Carbon::parse($request->gate_date)->toDateTimeString(),
        ]);
    }
}
