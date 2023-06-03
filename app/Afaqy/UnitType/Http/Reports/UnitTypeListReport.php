<?php

namespace Afaqy\UnitType\Http\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\UnitType\Models\UnitType;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\UnitType\Http\Transformers\UnitTypeTransformer;

class UnitTypeListReport extends Report
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
        $options['include'] = ['unitsCount'];

        return $this->generateViewList(
            $this->query(),
            new UnitTypeTransformer,
            $this->request,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = UnitType::withUnits();

        $query->select([
            'unit_types.id',
            'unit_types.name',
            DB::raw('COUNT(units.unit_type_id) as units_count'),
        ])
            ->groupBy(['unit_types.id', 'unit_types.name'])
            ->sortBy($this->request);

        return $query;
    }
}
