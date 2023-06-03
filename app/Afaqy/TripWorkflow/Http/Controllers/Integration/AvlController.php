<?php

namespace Afaqy\TripWorkflow\Http\Controllers\Integration;

use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\TripWorkflow\DTO\AVLUnitFinalDestinaionData;
use Afaqy\TripWorkflow\Http\Requests\AvlUnitEnterZoneRequest;
use Afaqy\TripWorkflow\Http\Requests\AvlUnitFinalDestinationRequest;
use Afaqy\TripWorkflow\Events\Failure\FailedToStoreUnitFinalDestination;
use Afaqy\TripWorkflow\Actions\PostTrip\StoreAvlUnitFinalDestinationAction;
use Afaqy\TripWorkflow\Events\Success\SuccessfullyStoredUnitFinalDestination;

class AvlController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return
     */
    public function enterZone(AvlUnitEnterZoneRequest $request)
    {
        return $this->returnSuccess('Unit zone stored successfully.');
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function finalDestination(AvlUnitFinalDestinationRequest $request)
    {
        $dto = AVLUnitFinalDestinaionData::fromRequest($request);

        $result = (new StoreAvlUnitFinalDestinationAction($dto))->execute();

        if ($result) {
            $message = 'Successfully stored final destination.';

            event(new SuccessfullyStoredUnitFinalDestination(resolve('ID'), $request, $message));

            return $this->returnSuccess($message);
        }

        $message = 'Failed to store Unit final destination information.';

        event(new FailedToStoreUnitFinalDestination(resolve('ID'), $request, $message));

        return $this->returnBadRequest(null, $message, []);
    }
}
