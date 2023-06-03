<?php

namespace Afaqy\TripWorkflow\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Afaqy\TripWorkflow\Providers\Events\FailureEventServiceProvider;
use Afaqy\TripWorkflow\Providers\Events\SuccessEventServiceProvider;
use Afaqy\TripWorkflow\Providers\Events\WorkFlowEventServiceProvider;
use Afaqy\TripWorkflow\Providers\Events\ViolationsEventServiceProvider;

class TripWorkflowServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('TripWorkflow', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(WorkFlowEventServiceProvider::class);
        $this->app->register(ViolationsEventServiceProvider::class);
        $this->app->register(SuccessEventServiceProvider::class);
        $this->app->register(FailureEventServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('TripWorkflow', 'Config/config.php') => config_path('tripworkflow.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('TripWorkflow', 'Config/config.php'),
            'tripworkflow'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/tripworkflow');

        $sourcePath = module_path('TripWorkflow', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/tripworkflow';
        }, \Config::get('view.paths')), [$sourcePath]), 'tripworkflow');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/tripworkflow');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'tripworkflow');
        } else {
            $this->loadTranslationsFrom(module_path('TripWorkflow', 'Resources/lang'), 'tripworkflow');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('TripWorkflow', 'Database/factories'));
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
