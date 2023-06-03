<?php

namespace Afaqy\District\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class DistrictPdfReport extends Report
{
    use Generator;

    /**
     * @var \Illuminate\Http\Request $request
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
     * @return mixed
     */
    public function generate()
    {
        $data = [
            'districts' => $this->query()->get(),
            'title'     => '‫‫قائمة‬ المناطق المسجلة في ‫مردم‬ جدة‬',
        ];

        $pdf = Pdf::loadView('district::exports.pdf.template', $data);

        if ($this->request->output == 'raw') {
            return $pdf->output();
        }

        return $pdf->download('districts.pdf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new DistrictExcelReport($this->request))->query();
    }
}
