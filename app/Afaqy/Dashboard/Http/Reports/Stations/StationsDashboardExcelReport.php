<?php

namespace Afaqy\Dashboard\Http\Reports\Stations;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\StationsReportFilter;
use Afaqy\Dashboard\Http\Reports\Stations\Exports\StationsDashboardExport;

class StationsDashboardExcelReport extends Report
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
        $name = 'stations_report_' . Carbon::now()->toDateString() . '.xlsx';

        return Excel::download(new StationsDashboardExport($this->query()), $name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new StationsDashboardReport($this->request))->query()
            ->filter($this->request->all(), StationsReportFilter::class);
    }
}
