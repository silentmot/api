<?php

namespace Afaqy\TripWorkflow\Actions\Entrance;

use Afaqy\Core\Actions\Action;
use Afaqy\Core\Facades\Tracer;
use Afaqy\TripWorkflow\Models\Trip;

class CheckPermissionTripExistsAction extends Action
{
    /**
     * @var array
     */
    private $unit;

    /**
     * @var array
     */
    private $devices;

    /**
     * @param array $unit
     * @param array $devices
     * @return void
     */
    public function __construct($unit, $devices)
    {
        $this->unit    = $unit;
        $this->devices = $devices;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $trip = (bool) Trip::withUnitInformation()
            ->where('trips_unit_info.qr_code', $this->unit['qr_code'])
            ->where('trips_unit_info.rfid', $this->unit['rfid'])
            ->where('trips_unit_info.unit_code', $this->unit['plate_number'])
            ->count();

        if ($trip) {
            Tracer::setErrorCode(8);
            Tracer::setErrorMessage(trans('tripworkflow::trip.permission-expired'));
            Tracer::setErrors([
                'area'            => 'entranceGate',
                'unit_identifier' => $this->unit['plate_number'],
                'message'         => [
                    'sound' => 3,
                    'text'  => config('tripworkflow.message.3'),
                ],
                'devices'         => $this->devices,
            ]);

            return true;
        }

        return false;
    }
}
