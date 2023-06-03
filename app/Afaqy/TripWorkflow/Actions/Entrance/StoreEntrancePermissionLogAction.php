<?php

namespace Afaqy\TripWorkflow\Actions\Entrance;

use Carbon\Carbon;
use Afaqy\Core\Actions\Action;
use Afaqy\Core\Facades\Tracer;
use Afaqy\TripWorkflow\Models\EntrancePermissionLog;

class StoreEntrancePermissionLogAction extends Action
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
     * @var int
     */
    private $create_time;

    /**
     * @param array $trip_data
     * @return void
     */
    public function __construct($trip_data)
    {
        $this->unit        = $trip_data['unit']['data'];
        $this->devices     = $trip_data['zone']['devices'];
        $this->create_time = $trip_data['create_time'];
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        if ($this->isSameRequest($this->unit['plate_number'])) {
            Tracer::setErrorCode(5);
            Tracer::setErrorMessage(trans('tripworkflow::trip.ignore-same-device-request'));

            return false;
        }

        $log = EntrancePermissionLog::create([
            'plate_number'    => $this->unit['plate_number'],
            'qr_code'         => $this->unit['qr_code'],
            'rfid'            => $this->unit['rfid'],
            'permission_type' => $this->unit['owner']['type'],
            'name'            => $this->unit['owner']['name'],
            'title'           => $this->unit['owner']['title'],
            'national_id'     => $this->unit['owner']['national_id'],
            'start_time'      => $this->create_time,
        ]);

        if (!$log) {
            Tracer::setErrorCode(4);
            Tracer::setErrorMessage(trans('tripworkflow::trip.fail-log-entrance-permission'));
            Tracer::setErrors([
                'area'            => 'entranceGate',
                'unit_identifier' => $this->unit['plate_number'],
                'devices'         => $this->devices,
            ]);

            return false;
        }

        Tracer::setSuccessMessage(trans('tripworkflow::trip.success-log-entrance-permission'));
        Tracer::setSuccessData([
            'area'           => 'entranceGate',
            'operation_type' => 'entrancePermission',
            'trip_id'        => $log->id,
            'unit'           => [
                'plate_number' => $this->unit['plate_number'],
                'qr_code'      => $this->unit['qr_code'],
                'rfid'         => $this->unit['rfid'],
            ],
            'message'        => [
                'sound' => 4,
                'text'  => config('tripworkflow.message.4'),
            ],
            'devices'         => $this->devices,
        ]);

        return true;
    }

    /**
     * @param  string  $plate_number
     * @return boolean
     */
    private function isSameRequest(string $plate_number): bool
    {
        $last_log = EntrancePermissionLog::where('plate_number', $plate_number)
            ->orderBy('id', 'desc')
            ->first();

        if (!$last_log) {
            return false;
        }

        $start_time = Carbon::createFromTimestamp($last_log->start_time);

        return $start_time->diffInMinutes(Carbon::now()) < config('tripworkflow.trivial_time_amount');
    }
}
