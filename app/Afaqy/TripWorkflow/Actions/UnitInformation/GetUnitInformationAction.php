<?php

namespace Afaqy\TripWorkflow\Actions\UnitInformation;

use Carbon\Carbon;
use Afaqy\Core\Actions\Action;
use Afaqy\Core\Facades\Tracer;

class GetUnitInformationAction extends Action
{
    /**
     * @var \Afaqy\TripWorkflow\DTO\CarData
     */
    private $data;

    /**
     * @var array
     */
    private $devices;

    /**
     * @param \Afaqy\TripWorkflow\DTO\CarData $data
     * @param array $devices
     * @return void
     */
    public function __construct($data, $devices)
    {
        $this->data    = $data;
        $this->devices = $devices;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $unit_checker = (new GetUnitCheckerAction($this->data))->execute();
        $date         = Carbon::fromTimestamp($this->data->client_create_date)->toDateString();

        $unit_type = $this->checkUnitType($unit_checker, $date);

        if (!$unit_type) {
            return false;
        }

        return $unit_type;
    }

    /**
     * @param  array  $checker
     * @param  string $date
     * @return array|null
     */
    private function checkUnitType(array $checker, string $date):  ? array
    {
        $entrance_unit = (new GetEntranceUnitInformationAction($checker, $date))->execute();

        if ($entrance_unit) {
            return [
                'type' => 'entrancePermission',
                'data' => $entrance_unit,
            ];
        }

        $contract_unit = (new GetContractUnitInformationAction($checker, $date))->execute();

        if ($contract_unit) {
            return [
                'type' => 'contract',
                'data' => $contract_unit,
            ];
        }

        $permission_unit = (new GetPermissionUnitInformationAction($checker))->execute();

        if ($permission_unit == 'wait for qr or rfid signal') {
            Tracer::setErrorCode(2);
            Tracer::setErrorMessage(trans('tripworkflow::trip.wait-for-qr'));
            Tracer::setErrors([
                'area'            => 'entranceGate',
                'unit_identifier' => $checker['value'],
                'devices'         => $this->devices,
            ]);

            return null;
        }

        if ($permission_unit) {
            return [
                'type' => 'permission',
                'data' => $permission_unit,
            ];
        }

        Tracer::setErrorCode(3);
        Tracer::setErrorMessage(trans('tripworkflow::trip.unit-not-found'));
        Tracer::setErrors([
            'area'            => 'entranceGate',
            'unit_identifier' => $checker['value'],
            'message'         => [
                'sound' => 3,
                'text'  => config('tripworkflow.message.3'),
            ],
            'devices'         => $this->devices,
        ]);

        return null;
    }
}
