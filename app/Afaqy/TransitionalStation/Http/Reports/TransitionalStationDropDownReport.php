<?php

namespace Afaqy\TransitionalStation\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\TransitionalStation\Models\TransitionalStation;
use Afaqy\TransitionalStation\Http\Transformers\TransitionalStationTransformer;

class TransitionalStationDropDownReport extends Report
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
        return $this->generateSelectList(
            $this->query(),
            new TransitionalStationTransformer,
            []
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = TransitionalStation::withDistricts();

        $query->distinct()->select([
            'transitional_stations.id',
            'transitional_stations.name',
        ])
            ->whereIn('districts.id', $this->request->districts)
            ->where('transitional_stations.status', 1)
            ->sortBy($this->request);

        return $query;
    }
}
