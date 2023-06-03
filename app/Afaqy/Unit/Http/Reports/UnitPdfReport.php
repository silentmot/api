<?php

namespace Afaqy\Unit\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class UnitPdfReport extends Report
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
        $data = [
            'units' => $this->query()->get(),
            'title' => 'قائمة مركبات مردم جدة',
        ];

        $pdf = Pdf::loadView('unit::pdf.temp', $data);

        if ($this->request->output == 'raw') {
            return $pdf->output();
        }

        return $pdf->download('units.pdf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new UnitExcelReport($this->request))->query();
    }
}
