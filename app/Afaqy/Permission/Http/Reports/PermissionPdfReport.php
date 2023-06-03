<?php

namespace Afaqy\Permission\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Afaqy\Permission\Models\Filters\PermissionFilter;

class PermissionPdfReport extends Report
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
            'permissions' => $this->query()->get(),
            'title'       => '‫‫قائمة‬ التصاريح المسجلة في ‫مردم‬ جدة‬',
        ];

        $pdf = Pdf::loadView('permission::exports.pdf.template', $data);

        if ($this->request->output == 'raw') {
            return $pdf->output();
        }

        return $pdf->download('permissions.pdf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new PermissionListReport($this->request))->query()
            ->filter($this->request->all(), PermissionFilter::class);
    }
}
