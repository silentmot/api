<?php

namespace Afaqy\Unit\Http\Reports;

use Afaqy\Unit\Models\Unit;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Unit\Http\Transformers\UnitShowTransformer;

class UnitShowReport extends Report
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
        return $this->generateViewShow(
            $this->query(),
            new UnitShowTransformer,
            ['unitType', 'wasteType', 'contractor']
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = Unit::withTypes()->withContractors();

        $query->select([
            'units.id',
            'units.code',
            'units.model',
            'units.plate_number',
            'units.vin_number',
            'unit_types.id as unit_id',
            'unit_types.name as unit_type',
            'waste_types.id as waste_id',
            'waste_types.name as waste_type',
            'units.net_weight',
            'units.max_weight',
            'units.rfid',
            'units.qr_code',
            'units.active',
            'units.contractor_id',
            'contractors.name_ar as contractor_name',
        ])
            ->where('units.id', $this->id);

        return $query;
    }
}
