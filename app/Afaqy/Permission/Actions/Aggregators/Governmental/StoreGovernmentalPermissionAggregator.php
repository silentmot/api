<?php

namespace Afaqy\Permission\Actions\Aggregators\Governmental;

use Afaqy\Core\Actions\Aggregator;
use Illuminate\Support\Facades\DB;
use Afaqy\Permission\Actions\StoreCheckinUnitsAction;
use Afaqy\Permission\Actions\StorePermissionLogAction;
use Afaqy\Permission\Actions\Governmental\StoreGovernmentalPermissionAction;

class StoreGovernmentalPermissionAggregator extends Aggregator
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
        DB::transaction(function () use (&$damaged_projects_permission) {
            $damaged_projects_permission = (new StoreGovernmentalPermissionAction($this->data->except('units')))->execute();

            (new StoreCheckinUnitsAction($this->data->units, $damaged_projects_permission))->execute();

            (new StorePermissionLogAction([
                'permission_number' => $this->data->permission_number,
                'permission_type'   => 'governmental',
                'allowed_weight'    => $this->data->allowed_weight ?? 0,
                'actual_weight'     => $this->data->actual_weight ?? 0,
            ]))->execute();
        });

        return $damaged_projects_permission;
    }
}
