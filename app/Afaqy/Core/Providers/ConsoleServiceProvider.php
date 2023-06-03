<?php

namespace Afaqy\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Afaqy\Core\Console\LaravelModules\Commands\DTOMakeCommand;
use Afaqy\Core\Console\LaravelModules\Commands\ActionMakeCommand;
use Afaqy\Core\Console\LaravelModules\Commands\FilterMakeCommand;
use Afaqy\Core\Console\LaravelModules\Commands\ReportMakeCommand;
use Afaqy\Core\Console\LaravelModules\Commands\AggregatorMakeCommand;
use Afaqy\Core\Console\LaravelModules\Commands\TransformerMakeCommand;
use Afaqy\Core\Console\LaravelModules\Commands\DTOCollectionMakeCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The available commands
     *
     * @var array
     */
    protected $commands = [
        ActionMakeCommand::class,
        AggregatorMakeCommand::class,
        DTOCollectionMakeCommand::class,
        DTOMakeCommand::class,
        FilterMakeCommand::class,
        ReportMakeCommand::class,
        TransformerMakeCommand::class,
    ];

    /**
     * Register the commands.
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function provides()
    {
        return $this->commands;
    }
}
