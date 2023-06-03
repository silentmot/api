<?php

namespace Afaqy\TripWorkflow\Actions\Aggregators;

use Afaqy\Core\Actions\Aggregator;
use Afaqy\TripWorkflow\Events\TripStarted;
use Afaqy\TripWorkflow\Actions\Entrance\StartTripAction;
use Afaqy\TripWorkflow\Actions\Entrance\GetRegisteredGeofenceAction;
use Afaqy\TripWorkflow\Actions\Entrance\HandleUnitUnendedTripsAction;
use Afaqy\TripWorkflow\Actions\Entrance\GetNextZonesInformationAction;
use Afaqy\TripWorkflow\Actions\Entrance\CheckPermissionTripExistsAction;

class StartTripAggregator extends Aggregator
{
    /**
     * @var array $trip_data
     */
    private $trip_data;

    /**
     * @param array $trip_data
     * @return void
     */
    public function __construct($trip_data)
    {
        $this->trip_data = $trip_data;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $unended_trips = (new HandleUnitUnendedTripsAction(
            $this->trip_data['unit']['data']['plate_number'],
            $this->trip_data['create_time']
        ))->execute();

        if (!$unended_trips) {
            return false;
        }

        if ($this->trip_data['unit']['type'] == 'permission') {
            $permission_trip_exist = (new CheckPermissionTripExistsAction(
                $this->trip_data['unit']['data'],
                $this->trip_data['zone']['devices']
            ))->execute();

            if ($permission_trip_exist) {
                return false;
            }
        }

        $this->trip_data['message'] = (new GetNextZonesInformationAction(
            $this->trip_data['unit']['data']['waste_type']
        ))->execute();

        if ($this->trip_data['unit']['type'] == 'contract') {
            $this->trip_data['registered_geofences'] = (new GetRegisteredGeofenceAction(
                $this->trip_data['unit']['data']['waste_type']
            ))->execute();
        }

        $trip = (new StartTripAction($this->trip_data))->execute();

        if (!$trip) {
            return false;
        }

        event(new TripStarted(resolve('ID'), $trip));

        return true;
    }
}
