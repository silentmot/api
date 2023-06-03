<?php

namespace Afaqy\Gate\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class GateServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        // $this->registerConfig();
        // $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Gate', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Gate', 'Config/config.php') => config_path('gate.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Gate', 'Config/config.php'),
            'gate'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/gate');

        $sourcePath = module_path('Gate', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/gate';
        }, \Config::get('view.paths')), [$sourcePath]), 'gate');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/gate');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'gate');
        } else {
            $this->loadTranslationsFrom(module_path('Gate', 'Resources/lang'), 'gate');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Gate', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
