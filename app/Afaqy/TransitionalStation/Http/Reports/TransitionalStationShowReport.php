<?php

namespace Afaqy\TransitionalStation\Http\Reports;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\TransitionalStation\Models\TransitionalStation;
use Afaqy\TransitionalStation\Http\Transformers\TransitionalStationShowTransformer;

class TransitionalStationShowReport extends Report
{
    use Generator;

    /**
     * @var int $request
     */
    private $id;

    /**
     * @param int $request
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
            new TransitionalStationShowTransformer,
            ['districts']
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
            'districts.id as district_id',
            'districts.name as district_name',
        ])
            ->where('transitional_stations.id', $this->id);

        return $query;
    }
}
