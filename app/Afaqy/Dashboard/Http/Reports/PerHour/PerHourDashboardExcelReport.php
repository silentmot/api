<?php

namespace Afaqy\Dashboard\Http\Reports\PerHour;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\PerHourReportFilter;
use Afaqy\Dashboard\Http\Reports\PerHour\Exports\PerHourDashboardExport;

class PerHourDashboardExcelReport extends Report
{
    /**
     * @var \Illuminate\Http\Request $request
     */
    private $request;

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        $name = 'per_hour_report_' . Carbon::now()->toDateString() . '.xlsx';

        return Excel::download(new PerHourDashboardExport($this->query()), $name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new PerHourDashboardReport($this->request))->query()
            ->filter($this->request->all(), PerHourReportFilter::class);
    }
}
