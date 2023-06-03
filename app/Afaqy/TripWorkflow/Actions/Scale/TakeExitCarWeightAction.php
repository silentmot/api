<?php

namespace Afaqy\TripWorkflow\Actions\Scale;

use Afaqy\Core\Actions\Action;
use Afaqy\Core\Facades\Tracer;
use Afaqy\TripWorkflow\Models\Trip;
use Afaqy\TripWorkflow\Events\TakeExitCarWeight;

class TakeExitCarWeightAction extends Action
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

        if ($trip->exit_weight) {
            Tracer::setErrorCode(5);
            Tracer::setErrorMessage(trans('tripworkflow::trip.ignore-same-device-request'));

            return false;
        }

        $trip->exit_scale_zone_id   = $this->data->zone_id;
        $trip->exit_scale_device_ip = $this->data->device_ip;
        $trip->exit_scale_ip        = $this->data->scale_ip;
        $trip->exit_weight          = $this->data->weight;
        $trip->end_time             = $this->data->weight_time;

        if ($trip->update()) {
            Tracer::setSuccessMessage(trans('tripworkflow::trip.success-take-weight'));

            event(new TakeExitCarWeight(resolve('ID'), $trip));

            return true;
        }

        Tracer::setErrorCode(10);
        Tracer::setErrorMessage(trans('tripworkflow::trip.cannot-take-weight'));

        return false;
    }
}
