<?php

namespace Afaqy\TripWorkflow\Actions\Aggregators;

use Afaqy\Core\Actions\Aggregator;
use Afaqy\TripWorkflow\Actions\UnitInformation\GetUnitInformationAction;
use Afaqy\TripWorkflow\Actions\Entrance\StoreEntrancePermissionLogAction;

class HandleEntranceZoneOperationsAggregator extends Aggregator
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
        $this->trip_data['unit'] = (new GetUnitInformationAction($this->data, $this->trip_data['zone']['devices']))->execute();

        if (!$this->trip_data['unit']) {
            return false;
        }

        if ($this->trip_data['unit']['type'] == 'entrancePermission') {
            return (new StoreEntrancePermissionLogAction($this->trip_data))->execute();
        }

        return (new StartTripAggregator($this->trip_data))->execute();
    }
}
