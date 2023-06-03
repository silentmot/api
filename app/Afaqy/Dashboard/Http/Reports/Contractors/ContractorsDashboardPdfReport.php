<?php

namespace Afaqy\Dashboard\Http\Reports\Contractors;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Afaqy\Dashboard\Models\Filters\ContractorReportFilter;
use Afaqy\Dashboard\Http\Reports\Contractors\Exports\ContractorsExportData;

class ContractorsDashboardPdfReport extends Report
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
        $name = 'contractors_report_' . Carbon::now()->toDateString();

        $export_data = (new ContractorsExportData($this->query()->get()));

        $data = [
            'headers'     => $export_data->header(),
            'contractors' => $export_data->data(),
            'title'       => 'تقرير المقاولين / ' . Carbon::now()->toDateString(),
        ];

        $pdf = Pdf::loadView('dashboard::exports.pdf.contractors.template', $data);

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
        return (new ContractorsDashboardReport($this->request))->query()
            ->filter($this->request->all(), ContractorReportFilter::class);
    }
}
