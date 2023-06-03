<?php

namespace Afaqy\Scale\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ScalePdfReport extends Report
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
            'scales' => $this->query()->get(),
            'title'  => '‫‫قائمة‬ موازين ‫مردم‬ جدة‬',
        ];

        $pdf = Pdf::loadView('scale::pdf.temp', $data);

        if ($this->request->output == 'raw') {
            return $pdf->output();
        }

        return $pdf->download('scales.pdf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new ScaleListReport($this->request))->query()->filter($this->request->all());
    }
}
