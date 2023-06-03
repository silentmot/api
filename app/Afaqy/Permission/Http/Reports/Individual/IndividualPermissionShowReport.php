<?php

namespace Afaqy\Permission\Http\Reports\Individual;

use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Permission\Models\IndividualDamagedPermission;
use Afaqy\Permission\Http\Transformers\Individual\IndividualPermissionShowTransformer;

class IndividualPermissionShowReport extends Report
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
        $options = [
            'units',
            'totalWeight',
        ];

        return $this->generateJoinViewShow(
            $this->query(),
            new IndividualPermissionShowTransformer,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = IndividualDamagedPermission::withNeighboorhood()
            ->WithDistrict()
            ->withPermitUnitsWithWeight()
            ->select([
                'individual_damaged_permissions.id as permission_id',
                'individual_damaged_permissions.demolition_serial',
                'individual_damaged_permissions.permission_number',
                'individual_damaged_permissions.permission_date',
                'individual_damaged_permissions.type',
                'neighborhoods.name as neighborhood_name',
                'districts.name as district_name',
                'individual_damaged_permissions.street',
                'individual_damaged_permissions.owner_name',
                'individual_damaged_permissions.national_id',
                'individual_damaged_permissions.owner_phone',
                'dashboard.start_time',
                DB::raw('CAST(dashboard.enterance_weight AS SIGNED) - CAST(dashboard.exit_weight AS SIGNED) AS weight'),
                'permit_units.id as unit_id',
                'permit_units.plate_number',
                'permit_units.qr_code',
                'permit_units.rfid',
            ])
            ->where('individual_damaged_permissions.id', $this->id)
            ->whereNull('permit_units.deleted_at');

        return $query;
    }
}
