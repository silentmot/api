<?php

namespace Afaqy\Dashboard\Helpers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportPeriod
{
    public function get(Request $request)
    {
        $start = ($request->from)
            ? Carbon::parse($request->from)->startOfDay()->toDateTimeString()
            : Carbon::today()->startOfDay()->toDateTimeString();

        $end = ($request->to)
            ? Carbon::parse($request->to)->endOfDay()->toDateTimeString()
            : Carbon::today()->endOfDay()->toDateTimeString();

        return [
            $start,
            $end,
        ];
    }
}
