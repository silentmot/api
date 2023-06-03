<?php

namespace Afaqy\TripWorkflow\Actions\Entrance;

use Carbon\Carbon;
use Afaqy\Core\Actions\Action;
use Afaqy\Core\Facades\Tracer;
use Illuminate\Support\Facades\DB;
use Afaqy\TripWorkflow\Models\Trip;
use Afaqy\TripWorkflow\Models\TripGeofence;
use Afaqy\TripWorkflow\Models\TripUnitInformation;

class StartTripAction extends Action
{
    /**
     * @var array
     */
    private $trip_data;

    /**
     * @param array $trip_data
     * @return void
     */
    public function __construct(array $trip_data)
    {
        $this->trip_data = $trip_data;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $trip = $this->openTrip($this->trip_data);

        if (!$trip) {
            Tracer::setErrorCode(7);
            Tracer::setErrorMessage(trans('tripworkflow::trip.cant-store-trip'));
            Tracer::setErrors([
                'area'            => 'entranceGate',
                'unit_identifier' => $this->trip_data['unit']['data']['plate_number'],
            ]);

            return false;
        }

        Tracer::setSuccessMessage(trans('tripworkflow::trip.success-start-trip'));
        Tracer::setSuccessData([
            'area'           => 'entranceGate',
            'operation_type' => 'startTrip',
            'trip_id'        => $trip->id,
            'unit'           => [
                'plate_number' => $trip->plate_number,
                'rfid'         => $this->trip_data['unit']['data']['rfid'],
                'qr_number'    => $this->trip_data['unit']['data']['qr_code'],
            ],
            'message'        => $this->trip_data['message'],
            'devices'        => $this->trip_data['zone']['devices'],
        ]);

        return $trip;
    }

    /**
     * @param  array $data
     * @return mixed
     */
    private function openTrip(array $data)
    {
        DB::transaction(function () use ($data, &$trip) {
            $trip = $this->storeTrip($data);

            $this->storeUnitInformation($trip, $data['unit']['data']);

            if ($data['unit']['type'] == 'contract') {
                $this->storeGeofencesInformation($trip, $data['registered_geofences']);
            }
        }, 3);

        return $trip;
    }

    /**
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function storeTrip(array $data)
    {
        $create_time = Carbon::fromTimestamp($data['create_time']);
        $year        = $create_time->format('Y');
        $month       = $create_time->format('m');
        $week        = $create_time->week(null, Carbon::SATURDAY);

        // if the start trip date in last days in December, that's will make this day belong to first week in
        // the new year.
        // So, we must update the year and month to the new year, otherwise, it will calculate it in first week in
        // the current year. Which is first day of it will be in the last year!
        // Ex: if we talk about 29-12-2019 that will make this day in first week in 2020, but when we convert this
        // in dashboard reports, Carbon lib will calculate this as (first week in 2019), and the start day of
        // this week will be 29-12-2018, so we must update the year and month, I hope this check make sense now
        // to you : )
        // Note: Why you do not make this in the query or the transformer?, because this is the simplest way and
        // it will not effect anything else : )
        if ($month == 12 && $week == 1) {
            $month = 1;
            $year++;
        }

        return Trip::create([
            'plate_number'       => $data['unit']['data']['plate_number'],
            'trip_unit_type'     => $data['unit']['type'],
            'entrance_zone_id'   => $data['zone']['id'],
            'entrance_device_ip' => $data['zone']['request']['device_ip'],
            'start_time'         => $data['create_time'],
            'year'               => $year,
            'month'              => $month,
            'week'               => $week,
        ]);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $trip
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function storeUnitInformation($trip, array $data)
    {
        return TripUnitInformation::create([
            'trip_id'           => $trip->id,
            'unit_id'           => $data['id'],
            'unit_code'         => $data['unit_code'] ?? null,
            'rfid'              => $data['rfid'],
            'qr_code'           => $data['qr_code'],
            'unit_type'         => $data['type'] ?? null,
            'waste_type'        => $data['waste_type'] ?? null,
            'net_weight'        => $data['net_weight'] ?? null,
            'max_weight'        => $data['max_weight'] ?? null,
            'permission_id'     => $data['permission']['id'] ?? null,
            'permission_type'   => $data['permission']['type'] ?? null,
            'permission_number' => $data['permission']['number'] ?? null,
            'demolition_serial' => $data['permission']['demolition_serial'] ?? null,
            'contract_id'       => $data['contract']['id'] ?? null,
            'contract_number'   => $data['contract']['number'] ?? null,
            'contract_type'     => $data['contract']['type'] ?? null,
            'contractor_id'     => $data['contractor']['id'] ?? null,
            'contractor_name'   => $data['contractor']['name'] ?? null,
            'avl_company'       => $data['contractor']['avl_company'] ?? null,
            'district_id'       => $data['district']['id'] ?? null,
            'district_name'     => $data['district']['name'] ?? null,
            'neighborhood_id'   => $data['district']['neighborhood']['id'] ?? null,
            'neighborhood_name' => $data['district']['neighborhood']['name'] ?? null,
            'station_id'        => $data['station']['id'] ?? null,
            'station_name'      => $data['station']['name'] ?? null,
        ]);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $trip
     * @param  array  $data
     * @return boolean
     */
    private function storeGeofencesInformation($trip, $data)
    {
        if (!$data) {
            return true;
        }

        foreach ($data as $key => $geofence) {
            $geofences[] = [
                'trip_id'         => $trip->id,
                'plate_number'    => $trip->plate_number,
                'geofence_status' => 'registered',
                'geofence_id'     => $geofence['id'],
                'geofence_name'   => $geofence['name'],
                'geofence_type'   => $geofence['type'],
            ];
        }

        return TripGeofence::insert($geofences);
    }
}
