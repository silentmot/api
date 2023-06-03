<?php

namespace Afaqy\EntrancePermission\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class EntrancePermissionServiceProvider extends ServiceProvider
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
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('EntrancePermission', 'Database/Migrations'));
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
            module_path('EntrancePermission', 'Config/config.php') => config_path('entrancepermission.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('EntrancePermission', 'Config/config.php'),
            'entrancepermission'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/entrancepermission');

        $sourcePath = module_path('EntrancePermission', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/entrancepermission';
        }, \Config::get('view.paths')), [$sourcePath]), 'entrancepermission');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/entrancepermission');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'entrancepermission');
        } else {
            $this->loadTranslationsFrom(module_path('EntrancePermission', 'Resources/lang'), 'entrancepermission');
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
            app(Factory::class)->load(module_path('EntrancePermission', 'Database/factories'));
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
