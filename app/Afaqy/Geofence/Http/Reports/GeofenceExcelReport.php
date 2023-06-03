<?php

namespace Afaqy\Geofence\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Maatwebsite\Excel\Facades\Excel;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Geofence\Http\Reports\Exports\GeofenceExport;

class GeofenceExcelReport extends Report
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
        return Excel::download(new GeofenceExport($this->query()), 'geofences.xlsx');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return (new GeofenceListReport($this->request))->query()->filter($this->request->all());
    }
}
