<?php

namespace Afaqy\Core\Listeners;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Events\CommandFinished;

class ExtendMakeModuleCommand
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Console\Events\CommandFinished  $event
     * @return void
     */
    public function handle(CommandFinished $event)
    {
        if ($event->command == 'module:make') {
            $name = 'Hold';

            if (!empty($event->input)) {
                $name = $event->input->getArgument('name')[0];
            }

            Artisan::call('module:make-model', [
                'model'  => $name,
                'module' => $name,
            ]);

            Artisan::call('module:make-action', [
                'action' => $name . 'Action',
                'module' => $name,
            ]);

            Artisan::call('module:make-dto', [
                'dto'    => $name . 'Data',
                'module' => $name,
            ]);

            Artisan::call('module:make-model-filter', [
                'model-filter' => $name . 'Filter',
                'module'       => $name,
            ]);

            Artisan::call('module:make-report', [
                'report' => $name . 'ListReport',
                'module' => $name,
            ]);

            Artisan::call('module:make-transformer', [
                'transformer' => $name . 'Transformer',
                'module'      => $name,
            ]);
        }
    }
}
