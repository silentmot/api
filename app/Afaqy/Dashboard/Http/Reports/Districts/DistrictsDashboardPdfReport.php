<?php

namespace Afaqy\Dashboard\Http\Reports\Districts;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Afaqy\Dashboard\Models\Filters\DistrictReportFilter;
use Afaqy\Dashboard\Http\Reports\Districts\Exports\DistrictExportData;

class DistrictsDashboardPdfReport extends Report
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
        $name = 'districts_report_' . Carbon::now()->toDateString();

        $export_data = (new DistrictExportData($this->query()->get()));

        $data = [
            'headers'   => $export_data->header(),
            'districts' => $export_data->data(),
            'title'     => 'تقرير البلديات / ' . Carbon::now()->toDateString(),
        ];

        $pdf = Pdf::loadView('dashboard::exports.pdf.districts.template', $data);

        if ($this->request->output == 'raw') {
            return $pdf->output();
        }

        return $pdf->download($name . '.pdf');
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
