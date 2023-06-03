<?php

namespace Afaqy\TransitionalStation\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class TransitionalStationPdfReport extends Report
{
    use Generator;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     *
     * @return mixed
     */
    public function generate()
    {
        $data = [
            'stations' => $this->query()->get(),
            'title'    => '‫‫قائمة‬ المحطات الانتقالية ‫مردم‬ جدة‬',
        ];

        $pdf = Pdf::loadView('transitionalstation::pdf.temp', $data);

        if ($this->request->output == 'raw') {
            return $pdf->output();
        }

        return $pdf->download('transitional-stations.pdf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new TransitionalStationExcelReport($this->request))->query();
    }
}
