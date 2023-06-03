<?php

namespace Afaqy\TripWorkflow\Actions\Scale;

use Afaqy\Core\Actions\Action;
use Afaqy\Core\Facades\Tracer;
use Afaqy\TripWorkflow\Models\Trip;
use Afaqy\TripWorkflow\Events\TakeEntranceCarWeight;

class TakeEntranceCarWeightAction extends Action
{
    /**
     * @var \Afaqy\TripWorkflow\DTO\CarWeightData $data
     */
    private $data;

    /**
     * @param \Afaqy\TripWorkflow\DTO\CarWeightData $data
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
        $trip = Trip::where('id', $this->data->trip_id)->first();

        if ($trip->enterance_weight) {
            Tracer::setErrorCode(5);
            Tracer::setErrorMessage(trans('tripworkflow::trip.ignore-same-device-request'));

            return false;
        }

        $trip->entrance_scale_zone_id   = $this->data->zone_id;
        $trip->entrance_scale_device_ip = $this->data->device_ip;
        $trip->enterance_scale_ip       = $this->data->scale_ip;
        $trip->enterance_weight         = $this->data->weight;
        $trip->enterance_weight_time    = $this->data->weight_time;

        if ($trip->update()) {
            Tracer::setSuccessMessage(trans('tripworkflow::trip.success-take-weight'));

            event(new TakeEntranceCarWeight(resolve('ID'), $trip));

            return true;
        }

        Tracer::setErrorCode(10);
        Tracer::setErrorMessage(trans('tripworkflow::trip.cannot-take-weight'));

        return false;
    }
}
