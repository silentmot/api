<?php

namespace Afaqy\TripWorkflow\Providers\Events;

use Afaqy\TripWorkflow\Listeners\Violations\StoreViolation;
use Afaqy\TripWorkflow\Events\Violations\UnendedTripViolation;
use Afaqy\TripWorkflow\Events\Violations\UnitUnloadedViolation;
use Afaqy\TripWorkflow\Events\Violations\UnitMaxWeightViolation;
use Afaqy\TripWorkflow\Events\Violations\UnitExceedNetWeightViolation;
use Afaqy\TripWorkflow\Events\Violations\UnitHasNotEntranceWeightViolation;
use Afaqy\TripWorkflow\Listeners\Notifications\SendUnendedTripNotifications;
use Afaqy\TripWorkflow\Listeners\Notifications\SendUnitUnloadedNotifications;
use Afaqy\TripWorkflow\Events\Violations\UnitNotPassedWashingStationViolation;
use Afaqy\TripWorkflow\Listeners\Notifications\SendUnitExceedNetWeightNotifications;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Afaqy\TripWorkflow\Listeners\Notifications\SendUnitMaxWeightViolationNotifications;
use Afaqy\TripWorkflow\Listeners\Notifications\SendUnitHasNotEntranceWeightNotifications;

class ViolationsEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UnendedTripViolation::class                 => [
            StoreViolation::class,
            SendUnendedTripNotifications::class,
        ],
        UnitMaxWeightViolation::class               => [
            StoreViolation::class,
            SendUnitMaxWeightViolationNotifications::class,
        ],
        UnitHasNotEntranceWeightViolation::class    => [
            StoreViolation::class,
            SendUnitHasNotEntranceWeightNotifications::class,
        ],
        UnitUnloadedViolation::class                => [
            StoreViolation::class,
            SendUnitUnloadedNotifications::class,
        ],
        UnitExceedNetWeightViolation::class                => [
            StoreViolation::class,
            SendUnitExceedNetWeightNotifications::class,
        ],
        UnitNotPassedWashingStationViolation::class => [
            StoreViolation::class,
        ],
    ];
}
