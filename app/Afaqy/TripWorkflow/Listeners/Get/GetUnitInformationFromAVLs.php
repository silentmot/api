<?php

namespace Afaqy\TripWorkflow\Listeners\Get;

use Carbon\Carbon;
use Afaqy\Unit\Models\Unit;
use Afaqy\TripWorkflow\Models\PreTrip;
use Illuminate\Contracts\Queue\ShouldQueue;
use Afaqy\TripWorkflow\Events\Failure\FailedToGetAVLCompanyUrl;
use Afaqy\TripWorkflow\Events\Failure\FailedToGetAVLCompanyName;
use Afaqy\TripWorkflow\Events\Failure\FailedToGetAvlUnitInformation;
use Afaqy\TripWorkflow\Events\Success\SuccessfullyGetAvlUnitInformation;

class GetUnitInformationFromAVLs implements ShouldQueue
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'high';

    /**
     * @var object
     */
    public $event;

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $this->event = $event;

        if ($avl_company = $this->getAvlCompany($event->data)) {
            if ($url = $this->getAvlRequestURL($avl_company)) {
                $this->getCarInfo($event->data, $url);
            }
        }

        return true;
    }

    /**
     * Get avl contractor company name to current unit
     *
     * @param  object  $data
     * @return mixed
     */
    public function getAvlCompany($data)
    {
        $unit = Unit::withContractors()->where('plate_number', $data->plate_number)->first();

        if ($unit->avl_company ?? false) {
            return $unit->avl_company;
        }

        event(new FailedToGetAVLCompanyName($this->event->log_id, $this->event->order));

        return false;
    }

    /**
     * Get avl contractor company url from config file
     *
     * @param  string $company
     * @return mixed
     */
    public function getAvlRequestURL($company)
    {
        $url = config('tripworkflow.avl.' . $company);

        if ($url) {
            return $url;
        }

        event(new FailedToGetAVLCompanyUrl($this->event->log_id, $this->event->order));

        return false;
    }

    /**
     * Get unit information for pre trip from avl provider
     * @param object $data
     * @param string $url
     * @return mixed
     */
    public function getCarInfo($data, $url)
    {
        $request = [
            'url'     => $url . '?' . http_build_query([
                'PlateNumber' => $data->plate_number,
            ]),
            'method'  => 'GET',
            'headers' => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ];

        $client = new \GuzzleHttp\Client($request['headers']);

        $response = $client->request($request['method'], $request['url']);

        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            event(new SuccessfullyGetAvlUnitInformation($this->event->log_id, $request, $response, $this->event->order));

            $content = json_decode($response->getBody()->getContents(), true);

            $unit_info = $this->StoreUnitInfo($data->id, $content);

            if ($unit_info) {
                return true;
            }
        }

        event(new FailedToGetAvlUnitInformation($this->event->log_id, $request, $response, $this->event->order));

        return false;
    }

    /**
     * Store unit pre trip info
     *
     * @param  int $trip_id
     * @param  array $data
     * @return mixed
     */
    public function StoreUnitInfo($trip_id, $data)
    {
        $depart_time = Carbon::parse($data->depart_time)->getTimestamp();

        $pre_trip = PreTrip::create([
            'trip_id'          => $trip_id,
            'shift_id'         => $data->shift_id,
            'depart_time'      => $depart_time,
            'depart_location'  => $data->depart_location,
            'plate_number'     => $data->plate_number,
            'route_id'         => $data->route_id,
            'trip_start_time'  => $data->trip_start_time,
            'total_containers' => $data->total_containers,
            'total_pick'       => $data->total_pick,
            'total_missing'    => $data->total_missing,
            'trip_end_time'    => $data->trip_end_time,
            'total_trip_time'  => $data->total_trip_time,
        ]);

        return $pre_trip;
    }
}
