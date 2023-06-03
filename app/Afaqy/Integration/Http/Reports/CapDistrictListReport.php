<?php

namespace Afaqy\Integration\Http\Reports;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\District\Models\District;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Integration\Http\Transformers\CapDistrictTransformer;

class CapDistrictListReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateJoinViewShow(
            $this->query(),
            new CapDistrictTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return District::withNeighborhoods()
            ->select([
                'districts.id',
                'districts.name',
                'neighborhoods.id as neighborhood_id',
                'neighborhoods.name as neighborhood_name',
            ])
            ->where('districts.status', 1)
            ->where('neighborhoods.status', 1)
            ->orderBy('id', 'desc');
    }
}
