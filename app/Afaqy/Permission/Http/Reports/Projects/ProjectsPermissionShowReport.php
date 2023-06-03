<?php

namespace Afaqy\Permission\Http\Reports\Projects;

use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Permission\Models\DamagedProjectsPermission;
use Afaqy\Permission\Http\Transformers\Projects\ProjectsPermissionShowTransformer;

class ProjectsPermissionShowReport extends Report
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
        $this->id  = $id;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        $options = ['units', 'totalWeight'];

        return $this->generateJoinViewShow(
            $this->query(),
            new ProjectsPermissionShowTransformer,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = DamagedProjectsPermission::withPermitUnitsWithWeight()
            ->select([
                'damaged_projects_permissions.id as permission_id',
                'damaged_projects_permissions.demolition_serial',
                'damaged_projects_permissions.permission_number',
                'damaged_projects_permissions.permission_date',
                'damaged_projects_permissions.company_name',
                'damaged_projects_permissions.company_commercial_number',
                'dashboard.start_time',
                DB::raw('CAST(dashboard.enterance_weight AS SIGNED) - CAST(dashboard.exit_weight AS SIGNED) AS weight'),
                'permit_units.id as unit_id',
                'permit_units.plate_number',
                'permit_units.qr_code',
                'permit_units.rfid',
            ])
            ->where('damaged_projects_permissions.id', $this->id)
            ->whereNull('permit_units.deleted_at');

        return $query;
    }
}
