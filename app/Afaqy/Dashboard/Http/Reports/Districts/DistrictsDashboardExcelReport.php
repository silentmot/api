<?php

namespace Afaqy\Dashboard\Http\Reports\Districts;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Maatwebsite\Excel\Facades\Excel;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\DistrictReportFilter;
use Afaqy\Dashboard\Http\Reports\Districts\Exports\DistrictExportData;
use Afaqy\Dashboard\Http\Reports\Districts\Exports\DistrictsDashboardExport;

class DistrictsDashboardExcelReport extends Report
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
        $name = 'districts_report_' . Carbon::now()->toDateString() . '.xlsx';

        $export_data = (new DistrictExportData($this->query()->get()));

        return Excel::download(new DistrictsDashboardExport($export_data->header(), $export_data->data()), $name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new DistrictsDashboardReport($this->request))->query()
            ->filter($this->request->all(), DistrictReportFilter::class);
    }
}
