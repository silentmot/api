<?php

namespace Afaqy\Zone\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ZonePdfReport extends Report
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
            'zones' => $this->query()->get(),
            'title' => '‫‫قائمة‬ المناطق داخل ‫مردم‬ جدة‬',
        ];

        $pdf = Pdf::loadView('zone::pdf.temp', $data);

        if ($this->request->output == 'raw') {
            return $pdf->output();
        }

        return $pdf->download('zones.pdf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new ZoneListReport($this->request))->query()->filter($this->request->all());
    }
}
