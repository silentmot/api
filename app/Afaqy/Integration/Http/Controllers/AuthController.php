<?php

namespace Afaqy\Integration\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Afaqy\Core\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct()
    {
        App::setLocale('en');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function token(Request $request)
    {
        $request->validate([
            'client_id'     => 'required|integer',
            'client_secret' => 'required|string',
        ]);

        try {
            $http = new \GuzzleHttp\Client;

            $response = $http->post(route('passport.token'), [
                'form_params' => [
                    'grant_type'    => 'client_credentials',
                    'client_id'     => $request->input('client_id'),
                    'client_secret' => $request->input('client_secret'),
                    'scope'         => explode('/', $request->path())[2],
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $this->returnSuccess('Successfully authenticate.', $data);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'credentials' => 'Wrong client credentials.',
            ]);
        }
    }
}
