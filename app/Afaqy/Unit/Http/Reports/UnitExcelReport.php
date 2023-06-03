<?php

namespace Afaqy\Unit\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Maatwebsite\Excel\Facades\Excel;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Unit\Http\Reports\Exports\UnitExport;

class UnitExcelReport extends Report
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
        return Excel::download(new UnitExport($this->query()), 'units.xlsx');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = (new UnitListReport($this->request))->query();

        $query->select([
            'units.code',
            'units.model',
            'units.plate_number',
            'units.vin_number',
            'unit_types.name as unit_type',
            'waste_types.name as waste_type',
            'contractors.name_ar as contractor_name',
            'units.net_weight',
            'units.max_weight',
            'units.rfid',
            'units.active',
        ])
            ->filter($this->request->all());

        return $query;
    }
}
