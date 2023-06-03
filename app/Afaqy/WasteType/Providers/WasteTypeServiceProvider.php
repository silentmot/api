<?php

namespace Afaqy\WasteType\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class WasteTypeServiceProvider extends ServiceProvider
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
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('WasteType', 'Database/Migrations'));
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
            module_path('WasteType', 'Config/config.php') => config_path('wastetype.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('WasteType', 'Config/config.php'),
            'wastetype'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/wastetype');

        $sourcePath = module_path('WasteType', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/wastetype';
        }, \Config::get('view.paths')), [$sourcePath]), 'wastetype');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/wastetype');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'wastetype');
        } else {
            $this->loadTranslationsFrom(module_path('WasteType', 'Resources/lang'), 'wastetype');
            $this->loadJsonTranslationsFrom(module_path('WasteType', 'Resources/lang'));
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
            app(Factory::class)->load(module_path('WasteType', 'Database/factories'));
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
