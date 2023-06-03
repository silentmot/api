<?php

namespace Afaqy\User\Http\Controllers\Auth;

use Afaqy\User\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Auth;
use Afaqy\Core\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['forgetToken', 'logout']);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return filter_var(request('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    /**
     * @SWG\Post(
     *  path="/v1/login",
     *  tags={"Auth"},
     *  summary="Logs user into the system",
     *  description="",
     *  operationId="loginUser",
     *  @SWG\Parameter(
     *      name="email", type="string", in="formData", description="The email or user name for login", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="password", type="string", in="formData", description="The password for the given user.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تسجيل الدخول بنجاح."),
     *      @SWG\Property(property="data", type="string", example={
     *          "tokenType"="Bearer",
     *          "expiresIn"=31622400,
     *          "accessToken"="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI0ZTMwMTIwZTRhMWM0NTMwNWVjNmZhZjQ5M2M1MzQ3MzFjOWRkMDQ3NWRjMGM4MjhiZTA0NDI1YTE5MjA3",
     *          "refreshToken"="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI0ZTMwMTIwZTRhMWM0NTMwNWVjNmZhZjQ5M2M1MzQ3MzFjOWRkMDQ3NWRjMGM4MjhiZTA0NDI1YTE5MjA3",
     *          "userId"="1",
     *      })
     *  )),
     *  @SWG\Response(response=422, description="Unprocessable Entity", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="The given data was invalid."),
     *      @SWG\Property(property="errors", type="string", example={
     *          "email"={"These credentials do not match our records."},
     *          "password"={"The password field is required."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
            'use_mob'  => 'sometimes|boolean',
        ]);

        try {
            $user = User::where($this->username(), $request->email)->firstOrFail();

            if ($user->status == 0) {
                return $this->returnBadRequest(2006, trans('user::auth.deactivated'));
            }

            if (!$this->inspectorCanUseMob($user)) {
                return $this->returnBadRequest(2010, trans('user::auth.mob_disable'), [
                    $this->username() => trans('user::auth.mob_disable'),
                ]);
            }

            $http   = new \GuzzleHttp\Client;
            $client = Client::where('password_client', 1)->firstOrFail();

            $response = $http->post(route('passport.token'), [
                'form_params' => [
                    'grant_type'    => 'password',
                    'client_id'     => $client->id,
                    'client_secret' => $client->secret,
                    'username'      => $request->email,
                    'password'      => $request->password,
                    'scope'         => '',
                ],
                'curl'        => [
                    CURLOPT_RESOLVE => [
                        preg_replace("(^https?://)", "", url('/')) . ':80:127.0.0.1',
                        preg_replace("(^https?://)", "", url('/')) . ':443:127.0.0.1',
                    ],
                ],
            ]);

            $data              = json_decode($response->getBody()->getContents(), true);
            $data['user_id']   = $user->id;
            $data['user_name'] = $user->first_name . ' ' . $user->last_name;

            return $this->returnSuccess(trans('user::auth.success'), $data);
        } catch (\Exception $e) {
            return $this->sendFailedLoginResponse(request());
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $user
     * @return boolean
     */
    private function inspectorCanUseMob($user): bool
    {
        if (request()->header('inspector-mob')) {
            return request()->header('inspector-mob') === 'true' && $user->use_mob;
        }

        return true;
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @throws \Illuminate\Validation\ValidationException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('user::auth.failed')],
        ]);
    }

    /**
     * @SWG\Post(
     *  path="/v1/logout",
     *  tags={"Auth"},
     *  summary="Logs user out of the system",
     *  description="",
     *  operationId="logoutUser",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تسجيل الخروج بنجاح."),
     *      @SWG\Property(property="data", type="string", example={})
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function forgetToken(Request $request)
    {
        $tokens = Auth::user()->tokens ?? [];

        foreach ($tokens as $token) {
            $token->revoke();
        }

        return $this->returnSuccess(trans('user::auth.success.logout'));
    }
}
