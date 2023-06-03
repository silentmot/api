<?php

namespace Afaqy\TransitionalStation\Http\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\TransitionalStation\Models\TransitionalStation;
use Afaqy\TransitionalStation\Http\Transformers\TransitionalStationTransformer;

class TransitionalStationListReport extends Report
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
        $options['include'] = ['districtsCount'];

        return $this->generateViewList(
            $this->query(),
            new TransitionalStationTransformer,
            $this->request,
            $options
        );
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
            DB::raw('COUNT(districts.id) as districts_count'),
        ])
            ->groupBy(['transitional_stations.id', 'transitional_stations.name', 'transitional_stations.status'])
            ->sortBy($this->request);

        return $query;
    }
}
