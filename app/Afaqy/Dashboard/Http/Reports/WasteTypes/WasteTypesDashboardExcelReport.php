<?php

namespace Afaqy\Dashboard\Http\Reports\WasteTypes;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Maatwebsite\Excel\Facades\Excel;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\WasteTypeReportFilter;
use Afaqy\Dashboard\Http\Reports\WasteTypes\Exports\WasteTypesExportData;
use Afaqy\Dashboard\Http\Reports\WasteTypes\Exports\WasteTypesDashboardExport;

class WasteTypesDashboardExcelReport extends Report
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
        $name = 'waste_types_report_' . Carbon::now()->toDateString() . '.xlsx';

        $export_data = (new WasteTypesExportData($this->query()->get()));

        return Excel::download(new WasteTypesDashboardExport($export_data->header(), $export_data->data()), $name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new WasteTypesDashboardReport($this->request))->query()
            ->filter($this->request->all(), WasteTypeReportFilter::class);
    }
}
