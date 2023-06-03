<?php

namespace Afaqy\Contract\Http\Reports\Show;

use Afaqy\Contract\Models\Contract;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Contract\Http\Transformers\Show\ContractDistrictsTransformer;

class ContractDistrictsReport extends Report
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
        $result = $this->query()->get()->toArray();

        if (!$result) {
            return [];
        }

        return $this->fractalItem($result, new ContractDistrictsTransformer);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Contract::withDistrictsIds()
            ->withDistricts()
            ->withNeighborhoods()
            ->withUnits()
            ->select([
                'districts.id as district_id',
                'districts.name as district_name',
                'neighborhoods.id as neighborhood_id',
                'neighborhoods.name as neighborhood_name',
                'units.id as unit_id',
                'units.plate_number',
            ])
            ->where('contracts.id', $this->id);

        // note:
            // if an error happened in the future you need to sort neighborhood_id and district_id asc :D
    }
}
