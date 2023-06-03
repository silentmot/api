<?php

namespace Afaqy\Inspector\Actions\Auth;

use Afaqy\Core\Actions\Action;
use Afaqy\Contact\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Afaqy\Inspector\Models\SupervisorOTP;

class OTPLoginAction extends Action
{
    /** @var int */
    private $otp;

    /**
     * @param int $otp
     * @return void
     */
    public function __construct(int $otp)
    {
        $this->otp = $otp;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $otp = SupervisorOTP::where('otp_code', $this->otp)->first();

        $supervisor = Contact::find($otp->contact_id);

        $token = $supervisor->createToken($supervisor->name)->accessToken;

        $otp->delete();

        Auth::login($supervisor);

        return [
            'token_type'   => "Bearer",
            'access_token' => $token,
            'user_id'      => $supervisor->id,
            'user_name'    => $supervisor->name,
        ];
    }
}
