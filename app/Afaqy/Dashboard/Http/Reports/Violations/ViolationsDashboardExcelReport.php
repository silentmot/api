<?php

namespace Afaqy\Dashboard\Http\Reports\Violations;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\ViolationsReportFilter;
use Afaqy\Dashboard\Http\Reports\Violations\Exports\ViolationsDashboardExport;

class ViolationsDashboardExcelReport extends Report
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
        $name = 'violations_report_' . Carbon::now()->toDateString() . '.xlsx';

        return Excel::download(new ViolationsDashboardExport($this->query()), $name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new ViolationsDashboardReport($this->request))->query()
            ->filter($this->request->all(), ViolationsReportFilter::class);
    }
}
