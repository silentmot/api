<?php

namespace Afaqy\Device\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Maatwebsite\Excel\Facades\Excel;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Device\Http\Reports\Exports\DeviceExport;

class DeviceExcelReport extends Report
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
        return Excel::download(new DeviceExport($this->query()), 'devices.xlsx');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new DeviceListReport($this->request))->query()->filter($this->request->all());
    }
}
