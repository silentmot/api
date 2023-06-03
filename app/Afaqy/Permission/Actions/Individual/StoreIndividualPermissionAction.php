<?php

namespace Afaqy\Permission\Actions\Individual;

use Afaqy\Core\Actions\Action;
use Afaqy\Permission\Models\IndividualDamagedPermission;

class StoreIndividualPermissionAction extends Action
{
    /** @var \Afaqy\Permission\DTO\IndividualPermissionData */
    private $data;

    /**
     * @param \Afaqy\Permission\DTO\IndividualPermissionData  $data
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
        $individual_permission = IndividualDamagedPermission::create([
            "demolition_serial"   => $this->data->demolition_serial,
            "type"                => $this->data->type,
            "district_id"         => $this->data->district_id,
            "neighborhood_id"     => $this->data->neighborhood_id,
            "street"              => $this->data->street,
            "owner_name"          => $this->data->owner_name,
            "owner_phone"         => $this->data->owner_phone,
            "national_id"         => $this->data->national_id,
            "permission_number"   => $this->data->permission_number,
            "permission_date"     => $this->data->permission_date,
        ]);


        return $individual_permission;
    }
}
