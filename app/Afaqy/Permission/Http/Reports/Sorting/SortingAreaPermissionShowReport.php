<?php

namespace Afaqy\Permission\Http\Reports\Sorting;

use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Permission\Models\SortingAreaPermission;
use Afaqy\Permission\Http\Transformers\Sorting\SortingAreaPermissionShowTransformer;

class SortingAreaPermissionShowReport extends Report
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
        $this->id   = $id;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        $options = ['units', 'totalWeight'];

        return $this->generateJoinViewShow(
            $this->query(),
            new SortingAreaPermissionShowTransformer,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = SortingAreaPermission::withPermitUnitsWithWeight()->withWasteType()
            ->select([
                'sorting_area_permissions.id as permission_id',
                'sorting_area_permissions.entity_name',
                'sorting_area_permissions.representative_name',
                'sorting_area_permissions.national_id',
                'sorting_area_permissions.allowed_weight',
                'dashboard.start_time',
                DB::raw('(CAST(dashboard.exit_weight AS SIGNED) - CAST(dashboard.enterance_weight AS SIGNED))/1000 AS weight'),
                'permit_units.id as unit_id',
                'permit_units.plate_number',
                'permit_units.qr_code',
                'permit_units.rfid',
                'waste_types.name as waste_type_name',
            ])
            ->where('sorting_area_permissions.id', $this->id)
            ->whereNull('permit_units.deleted_at');

        return $query;
    }
}
