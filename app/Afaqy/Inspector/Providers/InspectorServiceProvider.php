<?php

namespace Afaqy\Inspector\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class InspectorServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        // $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Inspector', 'Database/Migrations'));
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
            module_path('Inspector', 'Config/config.php') => config_path('inspector.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Inspector', 'Config/config.php'),
            'inspector'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/inspector');

        $sourcePath = module_path('Inspector', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/inspector';
        }, \Config::get('view.paths')), [$sourcePath]), 'inspector');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/inspector');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'inspector');
        } else {
            $this->loadTranslationsFrom(module_path('Inspector', 'Resources/lang'), 'inspector');
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
            app(Factory::class)->load(module_path('Inspector', 'Database/factories'));
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
