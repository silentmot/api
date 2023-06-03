<?php

namespace Afaqy\WasteType\Http\Reports;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\WasteType\Models\WasteType;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\WasteType\Http\Transformers\WasteTypeShowTransformer;

class WasteTypeShowReport extends Report
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
        return $this->generateJoinViewShow(
            $this->query(),
            new WasteTypeShowTransformer,
            ['scaleZones']
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = WasteType::withoutMardamWasteTypes()->withZones();

        $query->select([
            'waste_types.id',
            'waste_types.name',
            'waste_types.zone_id',
            'waste_types.pit_id',
            'zones.id as scale_zone_id',
            'zones.name as scale_zone_name',
        ])
            ->where('waste_types.id', $this->id);

        return $query;
    }
}
