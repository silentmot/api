<?php

namespace Afaqy\Inspector\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Responses\ResponseBuilder;

class VerifySupervisorHeadersKeys
{
    use ResponseBuilder;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasHeader('supervisor-id') || !$request->hasHeader('contract-id')) {
            return $this->returnBadRequest(
                400,
                "",
                [
                    'error' => trans('inspector::inspector.supervisor-headers-failed'),
                ]
            );
        }

        return $next($request);
    }
}
