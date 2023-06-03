<?php

namespace Afaqy\TripWorkflow\Console;

use Illuminate\Support\Facades\DB;

class TruncateRequestLogTable
{
    public function __invoke()
    {
        DB::table('slf_requests_checker')->truncate();
    }
}
