<?php

namespace Afaqy\TripWorkflow\Console;

use Carbon\Carbon;
use Afaqy\TripWorkflow\Models\IntegrationLog;

class DeleteLogOlderThanThirtyDays
{
    public function __invoke()
    {
        IntegrationLog::where('created_at', '<=', Carbon::today()->sub(30, 'days'))->delete();
    }
}
