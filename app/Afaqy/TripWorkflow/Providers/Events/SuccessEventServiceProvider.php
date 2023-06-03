<?php

namespace Afaqy\TripWorkflow\Providers\Events;

use Afaqy\TripWorkflow\Listeners\Logs\StoreIntegrationRequestLog;
use Afaqy\TripWorkflow\Events\Success\SuccessfullyHandleCarWeight;
use Afaqy\TripWorkflow\Events\Success\SuccessfullySendWeightToCap;
use Afaqy\TripWorkflow\Events\Success\SuccessfullyStoredViolation;
use Afaqy\TripWorkflow\Events\Success\SuccessfullySentWeightsToPLC;
use Afaqy\TripWorkflow\Events\Success\SuccessfullySendWeightToMasader;
use Afaqy\TripWorkflow\Events\Success\SuccessfullyHandleCarInformation;
use Afaqy\TripWorkflow\Events\Success\SuccessfullyGetAvlUnitInformation;
use Afaqy\TripWorkflow\Events\Success\SuccessfullyStoredUnitFinalDestination;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class SuccessEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SuccessfullySentWeightsToPLC::class           => [
            StoreIntegrationRequestLog::class,
        ],
        SuccessfullyGetAvlUnitInformation::class      => [
            StoreIntegrationRequestLog::class,
        ],
        SuccessfullyStoredUnitFinalDestination::class => [
            StoreIntegrationRequestLog::class,
        ],
        SuccessfullyHandleCarInformation::class       => [
            StoreIntegrationRequestLog::class,
        ],
        SuccessfullyHandleCarWeight::class            => [
            StoreIntegrationRequestLog::class,
        ],
        SuccessfullySendWeightToCap::class            => [
            StoreIntegrationRequestLog::class,
        ],
        SuccessfullySendWeightToMasader::class        => [
            StoreIntegrationRequestLog::class,
        ],
        SuccessfullyStoredViolation::class            => [
            StoreIntegrationRequestLog::class,
        ],
    ];
}
