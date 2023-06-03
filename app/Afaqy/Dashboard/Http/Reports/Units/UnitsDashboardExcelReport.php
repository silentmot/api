<?php

namespace Afaqy\Dashboard\Http\Reports\Units;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Maatwebsite\Excel\Facades\Excel;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\UnitReportFilter;
use Afaqy\Dashboard\Http\Reports\Units\Exports\UnitsDashboardExport;

class UnitsDashboardExcelReport extends Report
{
    use Generator;

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
        $name = 'units_report_' . Carbon::now()->toDateString() . '.xlsx';

        return Excel::download(new UnitsDashboardExport($this->query()), $name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new UnitsDashboardReport($this->request))->query()
            ->filter($this->request->all(), UnitReportFilter::class);
    }
}
