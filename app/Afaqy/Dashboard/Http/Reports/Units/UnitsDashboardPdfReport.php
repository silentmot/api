<?php

namespace Afaqy\Dashboard\Http\Reports\Units;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Afaqy\Dashboard\Models\Filters\UnitReportFilter;

class UnitsDashboardPdfReport extends Report
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
        $name = 'units_report_' . Carbon::now()->toDateString();

        $data = [
            'units' => $this->query()->get(),
            'title' => 'تقرير بدخول المركبات / ' . Carbon::now()->toDateString(),
        ];

        $pdf = Pdf::loadView('dashboard::exports.pdf.units.template', $data);

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
        return (new UnitsDashboardReport($this->request))->query()
            ->filter($this->request->all(), UnitReportFilter::class);
    }
}
