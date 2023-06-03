<?php

namespace Afaqy\TripWorkflow\Actions\Entrance;

use Carbon\Carbon;
use Afaqy\Core\Actions\Action;
use Afaqy\Core\Facades\Tracer;
use Afaqy\TripWorkflow\Models\Trip;
use Afaqy\TripWorkflow\Events\Violations\UnendedTripViolation;

class HandleUnitUnendedTripsAction extends Action
{
    /**
     * @var string
     */
    private $plate_number;

    /**
     * @var string
     */
    private $create_time;

    /**
     * @param string $plate_number
     * @return void
     */
    public function __construct($plate_number, $create_time)
    {
        $this->plate_number = $plate_number;
        $this->create_time  = $create_time;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $last_open_trip = $this->getLastOpenTrip($this->plate_number);

        if (!$last_open_trip) {
            return true;
        }

        if ($this->isSameRequest($last_open_trip->start_time)) {
            Tracer::setErrorCode(5);
            Tracer::setErrorMessage(trans('tripworkflow::trip.ignore-same-device-request'));

            return false;
        }

        $trip = $this->endLastOpenTrip($last_open_trip, $this->create_time);

        if (!$trip) {
            Tracer::setErrorCode(6);
            Tracer::setErrorMessage(trans('tripworkflow::trip.fail-end-unended-trip'));
            Tracer::setErrors([
                'area'            => 'entranceGate',
                'unit_identifier' => $this->plate_number,
            ]);
            // @TODO: need to fire fail event
            return false;
        }

        event(new UnendedTripViolation(resolve('ID'), $last_open_trip));

        return true;
    }

    /**
     * @param  string $plate_number
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function getLastOpenTrip(string $plate_number)
    {
        return Trip::where('plate_number', $plate_number)
            ->whereNull('end_time')
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * LPR devices send same request many times, we want ignore the request send in period of time
     * we declare it in trivial_time_amount variable, and close older than this amount of time.
     *
     * @param  int  $start_time
     * @return boolean
     */
    private function isSameRequest($start_time): bool
    {
        $start_time = Carbon::createFromTimestamp($start_time);

        return $start_time->diffInMinutes(Carbon::now()) < config('tripworkflow.trivial_time_amount');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $trip
     * @param  string $create_time
     * @return boolean
     */
    private function endLastOpenTrip($trip, $create_time): bool
    {
        $trip->end_time = $create_time;

        return (bool) $trip->update();
    }
}
