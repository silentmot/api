<?php

namespace Afaqy\TripWorkflow\Actions\Aggregators;

use Afaqy\Core\Actions\Aggregator;
use Afaqy\TripWorkflow\Actions\GetZoneInformationFromIpAction;

class HandleCarInformationAggregator extends Aggregator
{
    /**
     * @var \Afaqy\TripWorkflow\DTO\CarData $data
     */
    private $data;

    /**
     * @param \Afaqy\TripWorkflow\DTO\CarData $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $trip_data                = (new GetZoneInformationFromIpAction($this->data->device_ip))->execute();
        $trip_data['create_time'] = $this->data->client_create_date;

        if ($trip_data['zone']['type'] == 'entrance') {
            return (new HandleEntranceZoneOperationsAggregator($this->data, $trip_data))->execute();
        }

        if ($trip_data['zone']['type'] == 'entranceScale' || $trip_data['zone']['type'] == 'exit') {
            return (new HandleScaleZoneOperationsAggregator($this->data, $trip_data))->execute();
        }

        if ($trip_data['zone']['type'] == 'sorting') {
        }

        if ($trip_data['zone']['type'] == 'washing') {
        }

        if ($trip_data['zone']['type'] == 'incinerator') {
        }

        return true;
    }
}
