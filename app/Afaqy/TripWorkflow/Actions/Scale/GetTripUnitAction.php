<?php

namespace Afaqy\TripWorkflow\Actions\Scale;

use Afaqy\Core\Actions\Action;
use Afaqy\Core\Facades\Tracer;
use Afaqy\TripWorkflow\Models\Trip;
use Afaqy\TripWorkflow\Actions\UnitInformation\GetUnitCheckerAction;

class GetTripUnitAction extends Action
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

        $last_open_trip = $this->getLastOpenTrip($unit_checker);

        if ($last_open_trip) {
            Tracer::setSuccessData([
                'operation_type' => 'scale',
                'zone_type'      => $this->trip_data['zone']['type'],
                'trip_id'        => $last_open_trip->id,
                'unit'           => [
                    'plate_number' => $last_open_trip->plate_number,
                    'qr_code'      => $last_open_trip->qr_code,
                    'rfid'         => $last_open_trip->rfid,
                ],
                'devices'        => $this->trip_data['zone']['devices'],
                'scale'          => $this->trip_data['zone']['scale'],
            ]);

            return true;
        }

        Tracer::setErrorCode(9);
        Tracer::setErrorMessage(trans('tripworkflow::trip.unit-donnt-have-open-trips'));
        Tracer::setErrors([
            'area'            => 'entranceScale',
            'unit_identifier' => $unit_checker['value'],
        ]);

        return false;
    }

    /**
     * @param  array  $checker
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private function getLastOpenTrip(array $checker)
    {
        return Trip::withUnitInformation()
            ->select([
                'trips.id',
                'trips.plate_number',
                'trips_unit_info.rfid',
                'trips_unit_info.qr_code',
            ])
            ->where($checker['field'], $checker['value'])
            ->whereNull('end_time')
            ->orderBy('trips.id', 'desc')
            ->first();
    }
}
