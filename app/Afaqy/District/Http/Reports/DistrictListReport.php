<?php

namespace Afaqy\District\Http\Reports;

use Carbon\Carbon;
use Afaqy\Unit\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\District\Models\District;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\District\Http\Transformers\DistrictTransformer;

class DistrictListReport extends Report
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
        $options['include'] = [
            'neighborhoodsCount',
            'subNeighborhoodsCount',
            'unitsCount',
        ];

        return $this->generateViewList(
            $this->query(),
            new DistrictTransformer,
            $this->request,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = District::from($this->districtsWithNeighborhoodsCounts(), 'districts')
            ->select([
                'districts.id',
                'districts.name',
                'districts.points',
                'districts.neighborhoods_count',
                'districts.sub_neighborhoods_count',
                DB::raw('COUNT(units.id) as units_count'),
            ])
            ->leftJoinSub($this->activeContractsUnitsQuery(), 'units', 'units.district_id', '=', 'districts.id')
            ->groupBy([
                'districts.id',
                'districts.name',
                'districts.neighborhoods_count',
                'districts.sub_neighborhoods_count',
            ])
            ->sortBy($this->request);

        return $query;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function districtsWithNeighborhoodsCounts()
    {
        $query = District::withFilteredActiveAllNeighborhoods();

        $query->select([
            'districts.id',
            'districts.name',
            'districts.status',
            'districts.deleted_at',
            'districts.points',
            DB::raw('COUNT(DISTINCT neighborhoods.id) AS neighborhoods_count'),
            DB::raw('COUNT(sub_neighborhoods.id) AS sub_neighborhoods_count'),
        ])
            ->groupBy([
                'districts.id',
                'districts.name',
                'districts.status',
                'districts.deleted_at',
                'districts.points',
            ]);

        return $query;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function activeContractsUnitsQuery()
    {
        $query = Unit::withContracts();

        $query->select([
            'units.id',
            'contract_district.district_id',
        ])
            ->whereNull('contracts.deleted_at')
            ->where('contracts.status', 1)
            ->where('contracts.end_at', '>=', Carbon::now()->toDateString());

        return $query;
    }
}
