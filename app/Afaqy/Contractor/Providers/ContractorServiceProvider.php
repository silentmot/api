<?php

namespace Afaqy\Contractor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class ContractorServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('Contractor', 'Database/Migrations'));
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
            module_path('Contractor', 'Config/config.php') => config_path('contractor.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Contractor', 'Config/config.php'),
            'contractor'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/contractor');

        $sourcePath = module_path('Contractor', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/contractor';
        }, \Config::get('view.paths')), [$sourcePath]), 'contractor');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/contractor');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'contractor');
        } else {
            $this->loadTranslationsFrom(module_path('Contractor', 'Resources/lang'), 'contractor');
            $this->loadJsonTranslationsFrom(module_path('Contractor', 'Resources/lang'));
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
            app(Factory::class)->load(module_path('Contractor', 'Database/factories'));
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
