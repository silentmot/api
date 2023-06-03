<?php

namespace Afaqy\TransitionalStation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class TransitionalStationServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        //  $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('TransitionalStation', 'Database/Migrations'));
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
            module_path('TransitionalStation', 'Config/config.php') => config_path('transitionalstation.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('TransitionalStation', 'Config/config.php'),
            'transitionalstation'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/transitionalstation');

        $sourcePath = module_path('TransitionalStation', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/transitionalstation';
        }, \Config::get('view.paths')), [$sourcePath]), 'transitionalstation');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/transitionalstation');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'transitionalstation');
        } else {
            $this->loadTranslationsFrom(module_path('TransitionalStation', 'Resources/lang'), 'transitionalstation');
            $this->loadJsonTranslationsFrom(module_path('TransitionalStation', 'Resources/lang'));
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
            app(Factory::class)->load(module_path('TransitionalStation', 'Database/factories'));
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
