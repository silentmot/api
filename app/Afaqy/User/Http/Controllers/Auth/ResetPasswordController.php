<?php

namespace Afaqy\User\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Afaqy\User\Rules\PasswordComplexity;
use Afaqy\Core\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * @SWG\Post(
     *  path="/v1/password/reset",
     *  tags={"Auth"},
     *  summary="Reset the given user's password",
     *  description="",
     *  operationId="ResetPassword",
     *  @SWG\Parameter(
     *      name="token", type="string", in="formData", description="This password reset token", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="email", type="string", in="formData", description="The user email", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="password", type="string", in="formData", description="New Password", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="password_confirmation", type="string", in="formData", description="New Password confirmation", required=true
     *  ),
     *   @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Your password has been reset!"),
     *      @SWG\Property(property="data", type="string", example={}),
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="1003"),
     *      @SWG\Property(property="message", type="string", example="This password reset token is invalid."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=422, description="Unprocessable Entity", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="The given data was invalid."),
     *      @SWG\Property(property="errors", type="string", example={
     *          "email"={"The email must be a valid email address."},
     *          "password"={"The password must be at least 8 characters."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */

    /**
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        return $this->returnSuccess(trans('user::' . $response));
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return $this->returnBadRequest(1003, trans('user::' . $response));
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:6', 'max:10', new PasswordComplexity],
        ];
    }

    /**
     * redirect given token to fontEnd url
     *
     * @param  string $token
     * @param  string $email
     * @return Response
     */
    public function redirectToFront($token, $email)
    {
        return redirect(config('app.change_password_url') . '/' . $token . '/' . $email);
    }
}
