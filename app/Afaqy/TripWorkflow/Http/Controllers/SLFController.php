<?php

namespace Afaqy\TripWorkflow\Http\Controllers;

use Afaqy\Core\Facades\Tracer;
use Afaqy\TripWorkflow\DTO\CarData;
use Afaqy\TripWorkflow\DTO\CarWeightData;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\TripWorkflow\Http\Requests\SLFCarInfoRequest;
use Afaqy\TripWorkflow\Http\Requests\TakeCarWeightRequest;
use Afaqy\TripWorkflow\Events\Failure\FailedHandleCarWeight;
use Afaqy\TripWorkflow\Events\Failure\FailedHandleCarInformation;
use Afaqy\TripWorkflow\Http\Reports\EntranceScaleZonesListReport;
use Afaqy\TripWorkflow\Events\Success\SuccessfullyHandleCarWeight;
use Afaqy\TripWorkflow\Events\Success\SuccessfullyHandleCarInformation;
use Afaqy\TripWorkflow\Actions\Aggregators\HandleTakeCarWeightAggregator;
use Afaqy\TripWorkflow\Actions\Aggregators\HandleCarInformationAggregator;

class SLFController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function carInformation(SLFCarInfoRequest $request)
    {
        $dto = CarData::fromRequest($request);

        $result = (new HandleCarInformationAggregator($dto))->execute();

        if ($result) {
            event(new SuccessfullyHandleCarInformation(
                resolve('ID'),
                $request,
                [
                    'message' => Tracer::getSuccessMessage(),
                    'data'    => Tracer::getSuccessData(),
                ]
            ));

            return $this->returnSuccess(Tracer::getSuccessMessage(), Tracer::getSuccessData());
        }

        event(new FailedHandleCarInformation(
            resolve('ID'),
            $request,
            [
                'code'    => Tracer::getErrorCode(),
                'message' => Tracer::getErrorMessage(),
                'errors'  => Tracer::getErrors(),
            ]
        ));

        return $this->returnBadRequest(Tracer::getErrorCode(), Tracer::getErrorMessage(), Tracer::getErrors());
    }

    /**
     * update Car weight.
     */
    public function takeCarWeight(TakeCarWeightRequest $request)
    {
        $dto = CarWeightData::fromRequest($request);

        $result = (new HandleTakeCarWeightAggregator($dto))->execute();

        if ($result) {
            event(new SuccessfullyHandleCarWeight(
                resolve('ID'),
                $request,
                [
                    'message' => Tracer::getSuccessMessage(),
                    'data'    => Tracer::getSuccessData(),
                ]
            ));

            return $this->returnSuccess(Tracer::getSuccessMessage(), Tracer::getSuccessData());
        }

        event(new FailedHandleCarWeight(
            resolve('ID'),
            $request,
            [
                'code'    => Tracer::getErrorCode(),
                'message' => Tracer::getErrorMessage(),
                'errors'  => Tracer::getErrors(),
            ]
        ));

        return $this->returnBadRequest(Tracer::getErrorCode(), Tracer::getErrorMessage(), Tracer::getErrors());
    }

    /**
     * @return Response
     */
    public function getEntranceScaleZones()
    {
        return (new EntranceScaleZonesListReport)->show();
    }

    /**
     * @return Response
     */
    public function gateInfo()
    {
        return 'ok';
    }

    /**
     * @return Response
     */
    public function testToken()
    {
        return 'ok';
    }
}
