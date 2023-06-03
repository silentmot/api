<?php

namespace Afaqy\Contractor\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ContractorPdfReport extends Report
{
    use Generator;

    /**
     * @var \Illuminate\Http\Request
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
     * /**
     * @return mixed
     */
    public function generate()
    {
        $data = [
            'contractors' => $this->query()->get(),
            'title'       => '‫‫قائمة‬ مقاولين ‫مردم‬ جدة‬',
        ];

        $pdf = Pdf::loadView('contractor::exports.pdf.template', $data);

        if ($this->request->output == 'raw') {
            return $pdf->output();
        }

        return $pdf->download('contractors.pdf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new ContractorListReport($this->request))->query()->filter($this->request->all());
    }
}
