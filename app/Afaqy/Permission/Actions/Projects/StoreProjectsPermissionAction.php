<?php

namespace Afaqy\Permission\Actions\Projects;

use Afaqy\Core\Actions\Action;
use Afaqy\Permission\Models\DamagedProjectsPermission;

class StoreProjectsPermissionAction extends Action
{
    /** @var \Afaqy\Permission\DTO\ProjectsPermissionData */
    private $data;

    /**
     * @param \Afaqy\Permission\DTO\ProjectsPermissionData  $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $projects_permission = DamagedProjectsPermission::create([
            "demolition_serial"         => $this->data->demolition_serial,
            "permission_number"         => $this->data->permission_number,
            "permission_date"           => $this->data->permission_date,
            "company_name"              => $this->data->company_name,
            "company_commercial_number" => $this->data->company_commercial_number,
        ]);

        return $projects_permission;
    }
}
