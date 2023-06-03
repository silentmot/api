<?php

namespace Afaqy\TripWorkflow\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\TripWorkflow\Models\RequestChecker;
use Afaqy\Core\Http\Responses\ResponseBuilder;

class NotSameSlfRequest
{
    use ResponseBuilder;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $data = json_encode($request->except('create_date'));

        $last_request = RequestChecker::where('data', $data)->orderBy('id', 'desc')->first();

        if ($last_request) {
            $created_at = Carbon::parse($last_request->created_at);

            if ($created_at->diffInMinutes(Carbon::now()) < config('tripworkflow.trivial_time_amount')) {
                return $this->returnBadRequest(5, trans('tripworkflow::trip.ignore-same-device-request'));
            }

            $last_request->delete();
        }

        RequestChecker::create([
            'data' => $data,
        ]);

        return $next($request);
    }
}
