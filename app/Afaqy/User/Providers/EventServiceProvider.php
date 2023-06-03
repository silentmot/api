<?php

namespace Afaqy\User\Providers;

use Illuminate\Auth\Events\PasswordReset;
use Afaqy\User\Listeners\RevokeUserTokens;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        PasswordReset::class => [
            RevokeUserTokens::class,
        ],
    ];
}
