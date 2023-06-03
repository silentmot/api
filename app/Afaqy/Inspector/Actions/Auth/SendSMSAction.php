<?php

namespace Afaqy\Inspector\Actions\Auth;

use GuzzleHttp\Client;
use Afaqy\Core\Actions\Action;

class SendSMSAction extends Action
{
    /** @var int */
    private $otp;

    /**
     * @var string
     */
    private $phone;

    /**
     * @param int $otp
     * @param string $phone
     * @return void
     */
    public function __construct(int $otp, string $phone)
    {
        $this->otp   = $otp;
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $message = "رمز الدخول إلى تطبيق المفتش، يجب إدخال الرمز خلال دقيقة واحدة {$this->otp}";

        return $this->sendSmsMessage($this->phone, $message);
    }

    /**
     * @param string $phone
     * @param string $message
     * @return boolean
     */
    private function sendSmsMessage(string $phone, string $message): bool
    {
        // @TODO: use Laravel HTTP Client
        $client = new Client([
            'base_uri' => 'http://sms.afaqy.info:12055/http/',
            'timeout'  => 5.0,
        ]);

        try {
            $client->get('send-message', [
                'query' => [
                    'username' => 'egypt',
                    'password' => 'qwerty',
                    'to'       => $phone,
                    'message'  => $message,
                ],
            ]);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
