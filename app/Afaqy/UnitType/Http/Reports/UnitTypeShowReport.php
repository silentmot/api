<?php

namespace Afaqy\UnitType\Http\Reports;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\UnitType\Models\UnitType;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\UnitType\Http\Transformers\UnitTypeShowTransformer;

class UnitTypeShowReport extends Report
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
            new UnitTypeShowTransformer,
            ['wasteTypes']
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = UnitType::withWasteType();

        $query->select([
            'unit_types.id',
            'unit_types.name',
            'waste_types.id as waste_type_id',
            'waste_types.name as waste_type_name',
        ])
            ->where('unit_types.id', $this->id);

        return $query;
    }
}
