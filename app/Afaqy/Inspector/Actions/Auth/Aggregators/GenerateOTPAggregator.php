<?php

namespace Afaqy\Inspector\Actions\Auth\Aggregators;

use Afaqy\Core\Actions\Aggregator;
use Afaqy\Inspector\Actions\Auth\SendSMSAction;
use Afaqy\Inspector\Actions\Auth\GenerateOTPAction;

class GenerateOTPAggregator extends Aggregator
{
    /** @var string */
    private $phone;

    /**
     * @param string $phone
     * @return void
     */
    public function __construct(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $otp = (new GenerateOTPAction($this->phone))->execute()->otp_code;

        return (new SendSMSAction($otp, $this->phone))->execute();
    }
}
