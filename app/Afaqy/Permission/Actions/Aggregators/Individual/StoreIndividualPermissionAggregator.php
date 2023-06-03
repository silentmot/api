<?php

namespace Afaqy\Permission\Actions\Aggregators\Individual;

use Afaqy\Core\Actions\Aggregator;
use Illuminate\Support\Facades\DB;
use Afaqy\Permission\Actions\StoreCheckinUnitsAction;
use Afaqy\Permission\Actions\StorePermissionLogAction;
use Afaqy\Permission\Actions\Individual\StoreIndividualPermissionAction;

class StoreIndividualPermissionAggregator extends Aggregator
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
        DB::transaction(function () use (&$individual_permission) {
            $individual_permission   = (new StoreIndividualPermissionAction($this->data->except('units')))->execute();

            (new StoreCheckinUnitsAction($this->data->units, $individual_permission))->execute();

            (new StorePermissionLogAction([
                'permission_number' => $this->data->permission_number,
                'permission_type'   => 'individual',
                'allowed_weight'    => $this->data->allowed_weight ?? 0,
                'actual_weight'     => $this->data->actual_weight ?? 0,
            ]))->execute();
        });

        return $individual_permission;
    }
}
