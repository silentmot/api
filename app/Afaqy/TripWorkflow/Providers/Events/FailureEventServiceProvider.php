<?php

namespace Afaqy\TripWorkflow\Providers\Events;

use Afaqy\TripWorkflow\Events\Failure\FailStoreViolation;
use Afaqy\TripWorkflow\Events\Failure\FailSendWeightToCap;
use Afaqy\TripWorkflow\Events\Failure\FailSentWeightsToPLC;
use Afaqy\TripWorkflow\Events\Failure\FailedHandleCarWeight;
use Afaqy\TripWorkflow\Events\Failure\FailSendWeightToMasader;
use Afaqy\TripWorkflow\Events\Failure\FailedToGetAVLCompanyUrl;
use Afaqy\TripWorkflow\Events\Failure\FailedToGetAVLCompanyName;
use Afaqy\TripWorkflow\Events\Failure\FailedHandleCarInformation;
use Afaqy\TripWorkflow\Listeners\Logs\StoreIntegrationRequestLog;
use Afaqy\TripWorkflow\Events\Failure\WorkFlowInternalServerError;
use Afaqy\TripWorkflow\Events\Failure\FailedToGetAvlUnitInformation;
use Afaqy\TripWorkflow\Events\Failure\FailedToStoreUnitFinalDestination;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class FailureEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        WorkFlowInternalServerError::class       => [
            StoreIntegrationRequestLog::class,
        ],
        FailSentWeightsToPLC::class              => [
            StoreIntegrationRequestLog::class,
        ],
        FailedToGetAVLCompanyName::class         => [
            StoreIntegrationRequestLog::class,
        ],
        FailedToGetAVLCompanyUrl::class          => [
            StoreIntegrationRequestLog::class,
        ],
        FailedToGetAvlUnitInformation::class     => [
            StoreIntegrationRequestLog::class,
        ],
        FailedToStoreUnitFinalDestination::class => [
            StoreIntegrationRequestLog::class,
        ],
        FailedHandleCarInformation::class        => [
            StoreIntegrationRequestLog::class,
        ],
        FailedHandleCarWeight::class             => [
            StoreIntegrationRequestLog::class,
        ],
        FailSendWeightToCap::class               => [
            StoreIntegrationRequestLog::class,
        ],
        FailSendWeightToMasader::class           => [
            StoreIntegrationRequestLog::class,
        ],
        FailStoreViolation::class                => [
            StoreIntegrationRequestLog::class,
        ],
    ];
}
