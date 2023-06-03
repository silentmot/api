<?php

namespace Afaqy\District\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\District\Models\District;
use Maatwebsite\Excel\Facades\Excel;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\District\Http\Reports\Exports\DistrictExport;

class DistrictExcelReport extends Report
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
        return Excel::download(new DistrictExport($this->query()), 'districts.xlsx');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = District::withFilteredActiveAllNeighborhoods();

        $query->select([
            'districts.name as districtName',
            'neighborhoods.name as neighborhoodName',
            'neighborhoods.population as neighborhoodPopulation',
            'sub_neighborhoods.name as subNeighborhoodName',
        ])
            ->sortBy($this->request)
            ->filter($this->request->all());

        return $query;
    }
}
