<?php

namespace Afaqy\TripWorkflow\Listeners\Send;

use Illuminate\Contracts\Queue\ShouldQueue;
use Afaqy\TripWorkflow\Models\TripUnitInformation;
use Afaqy\TripWorkflow\Events\Failure\FailSentWeightsToPLC;
use Afaqy\TripWorkflow\Events\Success\SuccessfullySentWeightsToPLC;

class SendWeightToPLC implements ShouldQueue
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'high';

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->trip->trip_unit_type == 'contract') {
            return true;
        }

        if (!$data = $this->vaildPermissionType($event->trip)) {
            return true;
        }

        $request = [
            'url'           => config('tripworkflow.plc.url'),
            'function_name' => config('tripworkflow.plc.function_name'),
            'data'          => $data,
        ];

        $soapClient = new \SoapClient($request['url']);

        $response = $soapClient->__call($request['function_name'], $request['data']);

        if ($response->AddNewMardmResult == 0) {
            event(new SuccessfullySentWeightsToPLC($event->log_id, $request, $response->AddNewMardmResult, $event->order));

            return true;
        }

        event(new FailSentWeightsToPLC($event->log_id, $request, $response->AddNewMardmResult, $event->order));
    }

    /**
     * @param  array $trip
     * @return array|null
     */
    public function vaildPermissionType($trip)
    {
        $unit = TripUnitInformation::select([
            'permission_number',
            'demolition_serial',
        ])
            ->where('trip_id', $trip->id)
            ->whereIn('permission_type', ['individual', 'project'])
            ->first();

        if (!$unit) {
            return false;
        }

        return [
            "parameters" => [
                "guid"       => config('tripworkflow.plc.guid'),
                "card_ID"    => (string) $unit->demolition_serial, // رقم الدمار
                "LIC_ID"     => (string) $unit->permission_number, // رقم الرخصة
                "IN_weight"  => (string) $trip->enterance_weight, // وزن الدخول
                "out_weight" => (string) $trip->exit_weight, // وزن الخروج
                "user_id"    => null, // الرقم الوظيفى للمستخدم وهو اختيارى
            ],
        ];
    }
}
