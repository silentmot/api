<?php

namespace Afaqy\Inspector\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Inspector\Actions\Auth\OTPLoginAction;
use Afaqy\Inspector\Actions\Auth\RevokeTokenAction;
use Afaqy\Inspector\Http\Requests\Auth\LoginRequest;
use Afaqy\Inspector\Http\Requests\Auth\SupervisorPhoneRequest;
use Afaqy\Inspector\Actions\Auth\Aggregators\GenerateOTPAggregator;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Afaqy\Inspector\Http\Requests\Auth\SupervisorPhoneRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateOTP(SupervisorPhoneRequest $request): JsonResponse
    {
        $phone = $request->validated()['phone'];

        $result = (new GenerateOTPAggregator($phone))->execute();

        $messages = [
            'success' => 'inspector::inspector.generate-otp-success',
            'fail'    => 'inspector::inspector.generate-otp-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            100
        );
    }

    /**
     * @param \Afaqy\Inspector\Http\Requests\Auth\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $otp = $request->validated()['otp'];

        $data = (new OTPLoginAction($otp))->execute();

        return $this->returnSuccess(
            trans('inspector::inspector.login-success'),
            $data
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function revokeToken()
    {
        (new RevokeTokenAction)->execute();

        return $this->returnSuccess(
            trans('inspector::inspector.logout-success')
        );
    }
}
