<?php

namespace Afaqy\Permission\Actions\Aggregators\Sorting;

use Afaqy\Core\Actions\Aggregator;
use Illuminate\Support\Facades\DB;
use Afaqy\Permission\Actions\StoreCheckinUnitsAction;
use Afaqy\Permission\Actions\StorePermissionLogAction;
use Afaqy\Permission\Actions\Sorting\StoreSortingAreaPermissionAction;

class StoreSortingAreaPermissionAggregator extends Aggregator
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
        DB::transaction(function () use (&$sorting_area_permission) {
            $sorting_area_permission = (new StoreSortingAreaPermissionAction($this->data->except('units')))->execute();

            (new StoreCheckinUnitsAction($this->data->units, $sorting_area_permission))->execute();

            (new StorePermissionLogAction([
                'permission_number' => $sorting_area_permission->id,
                'permission_type'   => 'sorting',
                'allowed_weight'    => $this->data->allowed_weight ?? 0,
                'actual_weight'     => $this->data->actual_weight ?? 0,
            ]))->execute();
        });

        return $sorting_area_permission;
    }
}
