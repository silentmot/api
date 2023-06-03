<?php

namespace Afaqy\Permission\Actions\Sorting;

use Afaqy\Core\Actions\Action;
use Afaqy\Permission\Models\SortingAreaPermission;

class StoreSortingAreaPermissionAction extends Action
{
    /** @var \Afaqy\Permission\DTO\SortingAreaPermissionData */
    private $data;

    /**
     * @param \Afaqy\Permission\DTO\SortingAreaPermissionData  $data
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
        $sorting_Area_permission = SortingAreaPermission::create([
            "waste_type_id"             => $this->data->waste_type_id,
            "entity_name"               => $this->data->entity_name,
            "representative_name"       => $this->data->representative_name,
            "national_id"               => $this->data->national_id,
            "allowed_weight"            => $this->data->allowed_weight,
            "actual_weight"             => $this->data->actual_weight,

        ]);

        return $sorting_Area_permission;
    }
}
