<?php

namespace Afaqy\Inspector\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Contract\Models\Contract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Afaqy\Inspector\Actions\Auth\RevokeTokenAction;

class PreventSupervisourWithoutActiveContracts
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @throws AuthenticationException
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->isHasActiveContracts()) {
            (new RevokeTokenAction)->execute();

            throw new AuthenticationException;
        }

        return $next($request);
    }

    /**
     * @return boolean
     */
    private function isHasActiveContracts(): bool
    {
        $date = Carbon::now()->toDateString();

        return (bool) Contract::withContactsInformation()
            ->where('contracts.start_at', '<=', $date)
            ->where('contracts.end_at', '>=', $date)
            ->where('contracts.status', 1)
            ->where('phones.phone', Auth::user()->phones()->first()->phone)
            ->count();
    }
}
