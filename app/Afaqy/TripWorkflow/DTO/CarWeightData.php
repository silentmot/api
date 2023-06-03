<?php

namespace Afaqy\TripWorkflow\DTO;

use Carbon\Carbon;
use Afaqy\Zone\Models\Zone;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class CarWeightData extends FlexibleDataTransferObject
{
    /**
     * @var int
     */
    public $trip_id;

    /**
     * @var string|null
     */
    public $plate_number = null;

    /**
     * @var int
     */
    public $weight;

    /**
     * @var int
     */
    public $weight_time;

    /**
     * @var int
     */
    public $zone_id;

    /**
     * @var string
     */
    public $zone_type;

    /**
     * @var string
     */
    public $device_ip;

    /**
     * @var string
     */
    public $scale_ip;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        $zone = Zone::withDevices()
            ->select(['zones.id', 'zones.type'])
            ->where('ip', $request->device_ip)
            ->first();

        return new self([
            'trip_id'      => $request->trip_id,
            'plate_number' => $request->plate_number,
            'weight'       => $request->weight,
            'weight_time'  => Carbon::parse($request->weight_time)->getTimestamp(),
            'zone_id'      => $zone->id,
            'zone_type'    => $zone->type,
            'scale_ip'     => $request->scale_ip,
            'device_ip'    => $request->device_ip,
        ]);
    }
}
