<?php

namespace Afaqy\Permission\Actions\Commercial;

use Afaqy\Core\Actions\Action;
use Afaqy\Permission\Models\CommercialDamagedPermission;

class StoreCommercialPermissionAction extends Action
{
    /** @var \Afaqy\Permission\DTO\CommercialPermissionData */
    private $data;

    /**
     * @param \Afaqy\Permission\DTO\CommercialPermissionData  $data
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
        $projects_permission = CommercialDamagedPermission::create([
            "permission_number"         => $this->data->permission_number,
            "permission_date"           => $this->data->permission_date,
            "company_name"              => $this->data->company_name,
            "company_commercial_number" => $this->data->company_commercial_number,
            "representative_name"       => $this->data->representative_name,
            "national_id"               => $this->data->national_id,
            "allowed_weight"            => $this->data->allowed_weight,
            "actual_weight"             => $this->data->actual_weight,
        ]);

        return $projects_permission;
    }
}
