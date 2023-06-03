<?php

namespace Afaqy\Inspector\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Afaqy\Inspector\Actions\Auth\RevokeTokenAction;

class VerifyInspectorHasAbilityToUseApp
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @throws AuthenticationException
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->use_mob) {
            (new RevokeTokenAction)->execute();

            throw new AuthenticationException;
        }

        return $next($request);
    }
}
