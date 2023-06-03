<?php

namespace Afaqy\Dashboard\Http\Reports\WasteTypes;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Afaqy\Dashboard\Models\Filters\WasteTypeReportFilter;
use Afaqy\Dashboard\Http\Reports\WasteTypes\Exports\WasteTypesExportData;

class WasteTypesDashboardPdfReport extends Report
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
        $name = 'waste_type_report_' . Carbon::now()->toDateString();

        $export_data = (new WasteTypesExportData($this->query()->get()));

        $data = [
            'headers'     => $export_data->header(),
            'wasteTypes'  => $export_data->data(),
            'title'       => 'تقرير انواع النفايات / ' . Carbon::now()->toDateString(),
        ];

        $pdf = Pdf::loadView('dashboard::exports.pdf.waste-types.template', $data);

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
        return (new WasteTypesDashboardReport($this->request))->query()
            ->filter($this->request->all(), WasteTypeReportFilter::class);
    }
}
