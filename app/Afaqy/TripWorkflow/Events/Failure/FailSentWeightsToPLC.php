<?php

namespace Afaqy\TripWorkflow\Events\Failure;

use Illuminate\Queue\SerializesModels;
use Afaqy\TripWorkflow\Helpers\PrepareEventsRequest;

class FailSentWeightsToPLC
{
    use SerializesModels;
    use PrepareEventsRequest;

    /**
     * @var int
     */
    public $log_id;

    /**
     * @var int
     */
    public $order;

    /**
     * @var string
     */
    public $status = 'fail';

    /**
     * @var string
     */
    public $client = 'plc';

    /**
     * @var array
     */
    public $request;

    /**
     * @var array
     */
    public $response;

    /**
     * Create a new event instance.
     *
     * @param int $id
     * @param array $request
     * @param int $response
     * @param int $order
     * @return void
     */
    public function __construct($id, $request, $response, $order = 2)
    {
        $this->log_id   = $id;
        $this->order    = $order;
        $this->request  = $this->getRequest($request);
        $this->response = $this->getResponseMessage($response);
    }

    public function getResponseMessage($response)
    {
        $message = [];

        switch ($response) {
            case '-1028':
                $message = [
                    'code'    => $response,
                    'message' => 'GUID المستخدم غير صحيح',
                ];

                break;

            case '-1029':
                $message = [
                    'code'    => $response,
                    'message' => 'رقم الكارت المدخل غير صحيح',
                ];

                break;

            case '-1030':
                $message = [
                    'code'    => $response,
                    'message' => 'وزن الناقله عند الدخول يجب ان يكون اكبر من وزنها عند الخروج',
                ];

                break;

            case '-1031':
                $message = [
                    'code'    => $response,
                    'message' => 'رقم الرخصة المدخلة غير صحيحة',
                ];

                break;

            case '-1032':
                $message = [
                    'code'    => $response,
                    'message' => 'رقم البطاقة المدخلة لاتنتمي لرقم الرخصة المدخلة',
                ];

                break;

            case '-1033':
                $message = [
                    'code'    => $response,
                    'message' => 'رقم الرخصة يحتاج للمعالجة',
                ];

                break;

            default:
                $message[] = $response;

                break;
        }

        return $message;
    }
}
