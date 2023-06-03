<?php

namespace Afaqy\TransitionalStation\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Maatwebsite\Excel\Facades\Excel;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\TransitionalStation\Models\TransitionalStation;
use Afaqy\TransitionalStation\Http\Reports\Exports\TransitionalStationExport;

class TransitionalStationExcelReport extends Report
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
        return Excel::download(new TransitionalStationExport($this->query()), 'transitional-stations.xlsx');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = TransitionalStation::withDistricts();

        $query->select([
            'transitional_stations.id',
            'transitional_stations.name',
            'transitional_stations.status',
            'districts.name as district_name',
        ])
            ->whereNull('districts.deleted_at')
            ->sortBy($this->request)
            ->filter($this->request->all());

        return $query;
    }
}
