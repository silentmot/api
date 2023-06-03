<?php

namespace Afaqy\TripWorkflow\DTO;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class CarData extends FlexibleDataTransferObject
{
    /**
     * @var string|null
     */
    public $car_number = null;

    /**
     * @var int|null
     */
    public $card_number = null;

    /**
     * @var int|null
     */
    public $qr_number = null;

    /**
     * @var int|null
     */
    public $channel_id = null;

    /**
     * @var string|null
     */
    public $channel_name = null;

    /**
     * @var string
     */
    public $device_type;

    /**
     * @var string|null
     */
    public $photo_path = null;

    /**
     * @var string
     */
    public $device_ip;

    /**
     * @var boolean|null
     */
    public $is_authorized = null;

    /**
     * @var string|null
     */
    public $direction = null;

    /**
     * @var string|null
     */
    public $create_date = null;

    /**
     * @var int
     */
    public $client_create_date;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self([
            'car_number'         => $request->car_number,
            'card_number'        => $request->card_number,
            'qr_number'          => $request->qr_number,
            'channel_id'         => $request->channel_id,
            'channel_name'       => $request->channel_name,
            'device_type'        => $request->device_type,
            'device_ip'          => $request->device_ip,
            'is_authorized'      => $request->is_authorized,
            'photo_path'         => $request->photo_path,
            'direction'          => $request->direction,
            'create_date'        => Carbon::parse($request->create_date)->toDateTimeString(),
            'client_create_date' => Carbon::parse($request->client_create_date)->getTimestamp(),
        ]);
    }
}
