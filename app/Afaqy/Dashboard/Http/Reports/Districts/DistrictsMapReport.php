<?php

namespace Afaqy\Dashboard\Http\Reports\Districts;

use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Http\Transformers\Districts\DistrictsMapRerportTransformer;

class DistrictsMapReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateJoinViewShow(
            $this->query(),
            new DistrictsMapRerportTransformer,
            [],
            false
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Dashboard::select([
            'district_name',
            'districts.points as district_point',
            'neighborhood_name',
            'neighborhoods.points as neighborhood_point',
            DB::raw('sum(`enterance_weight`-`exit_weight`) as weight'),
        ])
            ->leftJoin('districts', 'districts.id', '=', 'dashboard.district_id')
            ->leftJoin('neighborhoods', 'neighborhoods.id', '=', 'dashboard.neighborhood_id')
            ->today()
            ->tripCompleted()
            ->where('trip_type', 'contract')
            ->groupBy([
                'district_name',
                'districts.points',
                'neighborhood_name',
                'neighborhoods.points',
            ]);
    }
}
