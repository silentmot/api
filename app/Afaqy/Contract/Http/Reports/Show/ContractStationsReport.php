<?php

namespace Afaqy\Contract\Http\Reports\Show;

use Afaqy\Contract\Models\Contract;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Contract\Http\Transformers\Show\ContractStationsTransformer;

class ContractStationsReport extends Report
{
    use Generator;

    /**
     * @var int $id
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
        $result = $this->query()->get();

        if ($result->first()->station_id) {
            $data = $result->groupBy('station_id')->toArray();

            return $this->fractalCollection($data, new ContractStationsTransformer)['data'];
        }

        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Contract::withStations()
            ->withStationUnits()
            ->select([
                'transitional_stations.id as station_id',
                'transitional_stations.name as station_name',
                'units.id as unit_id',
                'units.plate_number',
            ])
            ->where('contracts.id', $this->id);
    }
}
