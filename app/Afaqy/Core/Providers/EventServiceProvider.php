<?php

namespace Afaqy\Core\Providers;

use Illuminate\Console\Events\CommandFinished;
use Afaqy\Core\Listeners\ExtendMakeModuleCommand;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommandFinished::class => [
            ExtendMakeModuleCommand::class,
        ],
    ];
}
