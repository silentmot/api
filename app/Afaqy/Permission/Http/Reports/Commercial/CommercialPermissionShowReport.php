<?php

namespace Afaqy\Permission\Http\Reports\Commercial;

use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Permission\Models\CommercialDamagedPermission;
use Afaqy\Permission\Http\Transformers\Commercial\CommercialPermissionShowTransformer;

class CommercialPermissionShowReport extends Report
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
        $options = ['units', 'totalWeight'];

        return $this->generateJoinViewShow(
            $this->query(),
            new CommercialPermissionShowTransformer,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = CommercialDamagedPermission::withPermitUnitsWithWeight()
            ->select([
                'commercial_damaged_permissions.id as permission_id',
                'commercial_damaged_permissions.permission_number',
                'commercial_damaged_permissions.permission_date',
                'commercial_damaged_permissions.company_name',
                'commercial_damaged_permissions.company_commercial_number',
                'commercial_damaged_permissions.representative_name',
                'commercial_damaged_permissions.national_id',
                'commercial_damaged_permissions.allowed_weight',
                'dashboard.start_time',
                DB::raw('CAST(dashboard.enterance_weight AS SIGNED) - CAST(dashboard.exit_weight AS SIGNED) AS weight'),
                'permit_units.id as unit_id',
                'permit_units.plate_number',
                'permit_units.qr_code',
                'permit_units.rfid',
            ])
            ->where('commercial_damaged_permissions.id', $this->id)
            ->whereNull('permit_units.deleted_at');

        return $query;
    }
}
