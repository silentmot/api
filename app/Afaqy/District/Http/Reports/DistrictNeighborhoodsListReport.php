<?php

namespace Afaqy\District\Http\Reports;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\District\Models\Neighborhood;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\District\Http\Transformers\NeighborhoodTransformer;

class DistrictNeighborhoodsListReport extends Report
{
    use Generator;

    /**
     * @var int
     */
    private $district_id;

    /**
     * @param int $district_id
     * @return void
     */
    public function __construct(int $district_id)
    {
        $this->district_id = $district_id;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateSelectList(
            $this->query(),
            new NeighborhoodTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Neighborhood::select([
            'neighborhoods.id',
            'neighborhoods.name',
        ])
            ->where('district_id', $this->district_id)
            ->where('neighborhoods.status', 1);
    }
}
