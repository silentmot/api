<?php

namespace Afaqy\WasteType\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class WasteTypePdfReport extends Report
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
            'types' => $this->query()->get(),
            'title' => '‫‫قائمة‬ انواع النفايات ‫مردم‬ جدة‬',
        ];

        $pdf = Pdf::loadView('wastetype::exports.pdf.template', $data);

        if ($this->request->output == 'raw') {
            return $pdf->output();
        }

        return $pdf->download('wastes-types.pdf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new WasteTypeListReport($this->request))->query()->filter($this->request->all());
    }
}
