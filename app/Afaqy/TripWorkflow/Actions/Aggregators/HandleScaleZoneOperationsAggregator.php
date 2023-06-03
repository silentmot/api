<?php

namespace Afaqy\TripWorkflow\Actions\Aggregators;

use Afaqy\Core\Actions\Aggregator;
use Afaqy\TripWorkflow\Actions\Scale\GetTripUnitAction;
use Afaqy\TripWorkflow\Actions\Scale\GetEntrancePermissionUnitAction;

class HandleScaleZoneOperationsAggregator extends Aggregator
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
        $entrance_permission_unit = (new GetEntrancePermissionUnitAction($this->data, $this->trip_data))->execute();

        if ($entrance_permission_unit) {
            return true;
        }

        $trip_unit = (new GetTripUnitAction($this->data, $this->trip_data))->execute();

        if ($trip_unit) {
            return true;
        }

        return false;
    }
}
