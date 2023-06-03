<?php

namespace Afaqy\TripWorkflow\Providers\Events;

use Afaqy\TripWorkflow\Events\TripStarted;
use Afaqy\TripWorkflow\Events\TakeExitCarWeight;
use Afaqy\TripWorkflow\Events\TakeEntranceCarWeight;
use Afaqy\TripWorkflow\Listeners\Send\SendWeightToCap;
use Afaqy\TripWorkflow\Listeners\Send\SendWeightToPLC;
use Afaqy\TripWorkflow\Listeners\Logs\StorePermissionLog;
use Afaqy\TripWorkflow\Listeners\Send\SendWeightToMasader;
use Afaqy\TripWorkflow\Listeners\Get\GetUnitInformationFromAVLs;
use Afaqy\TripWorkflow\Listeners\Violations\CheckMaxWeightViolation;
use Afaqy\TripWorkflow\Listeners\Violations\CheckUnitUnloadedViolation;
use Afaqy\TripWorkflow\Listeners\Violations\CheckUnitExceedNetWeightViolation;
use Afaqy\TripWorkflow\Listeners\Violations\CheckUnitHasNotEntranceWeightViolation;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Afaqy\TripWorkflow\Listeners\Violations\CheckUnitNotPassedWashingStationViolation;

class WorkFlowEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        TripStarted::class           => [
            GetUnitInformationFromAVLs::class,
        ],
        TakeEntranceCarWeight::class => [
            CheckMaxWeightViolation::class,
        ],
        TakeExitCarWeight::class     => [
            CheckUnitHasNotEntranceWeightViolation::class,
            CheckUnitUnloadedViolation::class,
            CheckUnitNotPassedWashingStationViolation::class,
            CheckUnitExceedNetWeightViolation::class,
            SendWeightToPLC::class,
            SendWeightToCap::class,
            SendWeightToMasader::class,
            StorePermissionLog::class,
        ],
    ];
}
