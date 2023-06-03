<?php

namespace Afaqy\TripWorkflow\Actions\Scale;

use Carbon\Carbon;
use Afaqy\Core\Actions\Action;
use Afaqy\Core\Facades\Tracer;
use Afaqy\TripWorkflow\Models\EntrancePermissionLog;
use Afaqy\TripWorkflow\Actions\UnitInformation\GetUnitCheckerAction;
use Afaqy\TripWorkflow\Actions\UnitInformation\GetEntranceUnitInformationAction;

class GetEntrancePermissionUnitAction extends Action
{
    /**
     * @var \Afaqy\TripWorkflow\DTO\CarData $data
     */
    private $data;

    /**
     * @var array $trip_data
     */
    private $trip_data;

    /**
     * @param \Afaqy\TripWorkflow\DTO\CarData $data
     * @param array $trip_data
     * @return void
     */
    public function __construct($data, $trip_data)
    {
        $this->data      = $data;
        $this->trip_data = $trip_data;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $unit_checker = (new GetUnitCheckerAction($this->data))->execute();
        $date         = Carbon::fromTimestamp($this->data->client_create_date)->toDateString();

        $entrance_permission = (new GetEntranceUnitInformationAction($unit_checker, $date))->execute();

        if ($entrance_permission) {
            if ($this->trip_data['zone']['type'] == 'exit') {
                // if any error happened, it's not important to stop the whole operation.
                $this->endEntrancePermissionLog($entrance_permission['plate_number'], $this->trip_data['create_time']);
                // @TODO: fire fail log event
            }

            Tracer::setSuccessData([
                'operation_type' => 'scale',
                'zone_type'      => $this->trip_data['zone']['type'],
                'unit'           => [
                    'plate_number' => $entrance_permission['plate_number'],
                    'qr_code'      => $entrance_permission['qr_code'],
                    'rfid'         => $entrance_permission['rfid'],
                ],
                'devices'        => $this->trip_data['zone']['devices'],
            ]);

            return true;
        }

        return false;
    }

    /**
     * @param  string $plate_number
     * @param  int $end_time
     * @return boolean
     */
    public function endEntrancePermissionLog($plate_number, $end_time)
    {
        $permission = EntrancePermissionLog::where('plate_number', $plate_number)
            ->whereNull('end_time')
            ->orderBy('id')
            ->first();

        if ($permission) {
            $permission->end_time = $end_time;

            return (bool) $permission->update();
        }

        return false;
    }
}
