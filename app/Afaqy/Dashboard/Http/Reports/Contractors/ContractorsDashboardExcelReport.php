<?php

namespace Afaqy\Dashboard\Http\Reports\Contractors;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Maatwebsite\Excel\Facades\Excel;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\ContractorReportFilter;
use Afaqy\Dashboard\Http\Reports\Contractors\Exports\ContractorsExportData;
use Afaqy\Dashboard\Http\Reports\Contractors\Exports\ContractorsDashboardExport;

class ContractorsDashboardExcelReport extends Report
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
        $name = 'contractors_report_' . Carbon::now()->toDateString() . '.xlsx';

        $export_data = (new ContractorsExportData($this->query()->get()));

        return Excel::download(new ContractorsDashboardExport($export_data->header(), $export_data->data()), $name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new ContractorsDashboardReport($this->request))->query()
            ->filter($this->request->all(), ContractorReportFilter::class);
    }
}
