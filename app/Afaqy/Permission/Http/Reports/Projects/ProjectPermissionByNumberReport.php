<?php

namespace Afaqy\Permission\Http\Reports\Projects;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Permission\Models\DamagedProjectsPermission;
use Afaqy\Permission\Http\Transformers\Projects\ProjectsPermissionByNumberTransformer;

class ProjectPermissionByNumberReport extends Report
{
    use Generator;

    /**
     * @var int
     */
    private $number;

    /**
     * @param int $number
     * @return void
     */
    public function __construct($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        $options['include'] = 'units';

        return $this->generateJoinViewShow(
            $this->query(),
            new ProjectsPermissionByNumberTransformer(),
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = DamagedProjectsPermission::withPermitUnit();

        $query->select([
            "damaged_projects_permissions.id as permission_id",
            "damaged_projects_permissions.demolition_serial",
            "damaged_projects_permissions.permission_number",
            "damaged_projects_permissions.permission_date",
            "damaged_projects_permissions.company_name",
            "damaged_projects_permissions.company_commercial_number",
            "permit_units.id as unit_id",
            "permit_units.plate_number",
            'permit_units.qr_code',
            'permit_units.rfid',
        ])
            ->where("permission_number", $this->number)
            ->whereNull('permit_units.deleted_at');

        return $query;
    }
}
