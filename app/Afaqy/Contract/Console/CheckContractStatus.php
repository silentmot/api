<?php

namespace Afaqy\Contract\Console;

use Carbon\Carbon;
use Afaqy\Contract\Models\Contract;

class CheckContractStatus
{
    public function __invoke()
    {
        Contract::where('status', 1)
            ->where('end_at', '<', Carbon::today()->toDateString())
            ->orWhere('start_at', '>', Carbon::today()->toDateString())
            ->update(['status' => 0]);

        Contract::where('status', 0)
            ->orWhere('start_at', Carbon::today()->toDateString())
            ->update(['status' => 1]);

        return true;
    }
}
