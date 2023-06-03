<?php

namespace Afaqy\Permission\Actions\Governmental;

use Afaqy\Core\Actions\Action;
use Afaqy\Permission\Models\GovernmentalDamagedPermission;

class StoreGovernmentalPermissionAction extends Action
{
    /** @var \Afaqy\Permission\DTO\GovernmentalPermissionData */
    private $data;

    /**
     * @param \Afaqy\Permission\DTO\GovernmentalPermissionData  $data
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
        $projects_permission = GovernmentalDamagedPermission::create([
            "permission_number"           => $this->data->permission_number,
            "permission_date"             => $this->data->permission_date,
            "entity_name"                 => $this->data->entity_name,
            "representative_name"         => $this->data->representative_name,
            "allowed_weight"              => $this->data->allowed_weight,
            "national_id"                 => $this->data->national_id,
            "actual_weight"               => $this->data->actual_weight,
        ]);


        return $projects_permission;
    }
}
