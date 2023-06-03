<?php

namespace Afaqy\Role\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Illuminate\Database\Eloquent\Builder;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class RolePdfReport extends Report
{
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
     * @return mixed
     */
    public function generate()
    {
        $data = [
            'roles' => $this->query()->get(),
            'title' => 'قائمة وظائف مردم جدة',
        ];

        $pdf = Pdf::loadView('role::exports.pdf.template', $data);

        if ($this->request->output == 'raw') {
            return $pdf->output();
        }

        return $pdf->download('roles.pdf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new RoleListReport($this->request))->query()->filter($this->request->all());
    }
}
