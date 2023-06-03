<?php

namespace Afaqy\Dashboard\Http\Reports\PerHour;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Afaqy\Dashboard\Models\Filters\PerHourReportFilter;

class PerHourDashboardPdfReport extends Report
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
        $name = 'per_hour_report_' . Carbon::now()->toDateString();

        $data = [
            'perHour' => $this->query()->get(),
            'title'   => 'تقرير الازوان بالساعة / ' . Carbon::now()->toDateString(),
        ];

        $pdf = Pdf::loadView('dashboard::exports.pdf.per-hour.template', $data);

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
        return (new PerHourDashboardReport($this->request))->query()
            ->filter($this->request->all(), PerHourReportFilter::class);
    }
}
