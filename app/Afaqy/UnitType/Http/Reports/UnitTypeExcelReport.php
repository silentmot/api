<?php

namespace Afaqy\UnitType\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Maatwebsite\Excel\Facades\Excel;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\UnitType\Http\Reports\Exports\UnitTypeExport;

class UnitTypeExcelReport extends Report
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
        return Excel::download(new UnitTypeExport($this->query()), 'unit-types.xlsx');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new UnitTypeListReport($this->request))->query()->filter($this->request->all());
    }
}
