<?php

namespace Afaqy\Permission\Http\Reports\Governmental;

use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Permission\Models\GovernmentalDamagedPermission;
use Afaqy\Permission\Http\Transformers\Governmental\GovernmentalPermissionShowTransformer;

class GovernmentalPermissionShowReport extends Report
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
            new GovernmentalPermissionShowTransformer,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = GovernmentalDamagedPermission::withPermitUnitsWithWeight()
            ->select([
                'governmental_damaged_permissions.id as permission_id',
                'governmental_damaged_permissions.permission_number',
                'governmental_damaged_permissions.permission_date',
                'governmental_damaged_permissions.representative_name',
                'governmental_damaged_permissions.entity_name',
                'governmental_damaged_permissions.allowed_weight',
                'governmental_damaged_permissions.national_id',
                'dashboard.start_time',
                DB::raw('CAST(dashboard.enterance_weight AS SIGNED) - CAST(dashboard.exit_weight AS SIGNED) AS weight'),
                'permit_units.id as unit_id',
                'permit_units.plate_number',
                'permit_units.qr_code',
                'permit_units.rfid',
            ])
            ->where('governmental_damaged_permissions.id', $this->id)
            ->whereNull('permit_units.deleted_at');

        return $query;
    }
}
