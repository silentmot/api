<?php

namespace Afaqy\District\Http\Reports;

use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\District\Models\District;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\District\Http\Transformers\DistrictShowTransformer;

class DistrictShowReport extends Report
{
    use Generator;

    /**
     * @var int $request
     */
    private $id;

    /**
     * @param int $id
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateJoinViewShow(
            $this->query(),
            new DistrictShowTransformer,
            ['neighborhoods']
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = District::withAllNeighborhoods();

        $query->select([
            'districts.id',
            'districts.name',
            'districts.status',
            'districts.points',
            'neighborhoods.id as neighborhood_id',
            'neighborhoods.name as neighborhood_name',
            'neighborhoods.population as neighborhood_population',
            'neighborhoods.status as neighborhood_status',
            'neighborhoods.points as neighborhood_points',
            DB::raw('GROUP_CONCAT(sub_neighborhoods.name) as sub_neighborhoods'),
        ])
            ->where('districts.id', $this->id)
            ->groupBy([
                'districts.id',
                'districts.name',
                'districts.status',
                'districts.points',
                'neighborhoods.id',
                'neighborhoods.name',
                'neighborhoods.population',
                'neighborhoods.status',
                'neighborhoods.points',
            ]);

        return $query;
    }
}
