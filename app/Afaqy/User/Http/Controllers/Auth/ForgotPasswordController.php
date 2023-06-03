<?php

namespace Afaqy\User\Http\Controllers\Auth;

use Afaqy\User\Models\User;
use Illuminate\Http\Request;
use Afaqy\Contractor\Rules\EmailFormat;
use Illuminate\Support\Facades\Password;
use Afaqy\Core\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * @SWG\Post(
     *  path="/v1/password/email",
     *  tags={"Auth"},
     *  summary="Send a reset link to the given user",
     *  description="",
     *  operationId="ForgetPassword",
     *  @SWG\Parameter(
     *      name="email", type="string", in="formData", description="The email that will receive reset linke", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="We sent your password reset link!"),
     *      @SWG\Property(property="data", type="string", example={}),
     *  )),
     *  @SWG\Response(response=422, description="Unprocessable Entity", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="The given data was invalid."),
     *      @SWG\Property(property="errors", type="string", example={
     *          "email"={"The email must be a valid email address."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $this->returnSuccess(trans('user::' . $response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return $this->returnSuccess(trans('user::'.$response)." ". $request->input('email'));
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => ['required', new EmailFormat ]]);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $user = User::where('email', $request->email)->first();

        if ($user && ! $user->status) {
            return $this->returnBadRequest(2006, trans('user::auth.deactivated'));
        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }
}
