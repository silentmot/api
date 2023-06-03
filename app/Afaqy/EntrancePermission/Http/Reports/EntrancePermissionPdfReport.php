<?php

namespace Afaqy\EntrancePermission\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class EntrancePermissionPdfReport extends Report
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
            'permissions' => $this->query()->get(),
            'title'       => '‫‫قائمة‬ تصاريح الدخول بمردم جدة‬',
        ];

        $pdf = Pdf::loadView('entrancepermission::pdf.temp', $data);

        if ($this->request->output == 'raw') {
            return $pdf->output();
        }

        return $pdf->download('entrance-permissions.pdf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new EntrancePermissionListReport($this->request))->query()->filter($this->request->all());
    }
}
