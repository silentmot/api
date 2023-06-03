<?php

namespace Afaqy\TripWorkflow\Listeners\Send;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Afaqy\TripWorkflow\Events\Failure\FailSendWeightToMasader;
use Afaqy\TripWorkflow\Events\Success\SuccessfullySendWeightToMasader;

class SendWeightToMasader implements ShouldQueue
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
        $request = [
            'url'  => config('tripworkflow.masader.log_url'),
            'type' => 'post',
            'data' => $this->getData($event->trip),
        ];

        try {
            $token = $this->getAccessToken();

            $response = (new Client)->post(config('tripworkflow.masader.log_url'), [
                'form_params' => $request['data'],
                'headers'     => [
                    'Accept'        => 'application/json',
                    'Authorization' => "Bearer {$token}",
                ],
            ]);

            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                event(new SuccessfullySendWeightToMasader($event->log_id, $request, $response, $event->order));

                return true;
            }

            event(new FailSendWeightToMasader($event->log_id, $request, $response, $event->order));
        } catch (\Exception $e) {
            // need to refactor, when use laravel 8 HTTP client
            event(new FailSendWeightToMasader($event->log_id, $request, [
                'status_code' => 500,
                'message'     => $e->getMessage(),
            ], $event->order));
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $trip
     * @return array
     */
    private function getData($trip)
    {
        return [
            "PlateNumber" => $this->format($trip->plate_number),
            "TimeIn"      => Carbon::parse($trip->enterance_weight_time)->format('Y-m-d H:i'),
            "WeightIn"    => $trip->enterance_weight,
            'TimeOut'     => Carbon::parse($trip->end_time)->format('Y-m-d H:i'),
            "WeightOut"   => $trip->exit_weight,
        ];
    }

    /**
     * format plate number according to CAP rules.
     *
     * @param  string $plate_number
     * @return string
     */
    public function format(string $plate_number): string
    {
        preg_match("/[a-zA-z]+/", $plate_number, $letters);
        preg_match("/[0-9]+/", $plate_number, $numbers);

        $plate_number = $numbers[0] . '/' . implode('-', str_split($letters[0]));

        return $plate_number;
    }

    private function getAccessToken()
    {
        $response = (new Client)->post(config('tripworkflow.masader.login_url'), [
            'form_params' => [
                'username' => config('tripworkflow.masader.username'),
                'password' => config('tripworkflow.masader.password'),
            ],
            'headers'     => [
                'Accept' => 'application/json',
            ],
        ]);

        $responseBody = json_decode((string) $response->getBody(), true);

        return $responseBody['token'];
    }
}
