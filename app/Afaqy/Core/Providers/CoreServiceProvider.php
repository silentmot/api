<?php

namespace Afaqy\Core\Providers;

use Afaqy\Core\Helpers\ID;
use Afaqy\Core\Helpers\Tracer;
use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        Passport::tokensCan([
            'zk'      => 'Zk integration',
            'avl'     => 'AVL integration',
            'masader' => 'Masader integration',
            'cap'     => 'CAP integration',
            'slf'     => 'slf integration',
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('tracer', function ($app) {
            return new Tracer;
        });

        $this->app->singleton('ID', function ($app) {
            return (new ID)->generate();
        });

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(ConsoleServiceProvider::class);
    }
}
