<?php

namespace Afaqy\Permission\Actions\Aggregators;

use Afaqy\Core\Actions\Aggregator;
use Illuminate\Support\Facades\DB;
use Afaqy\Permission\Actions\StoreCheckinUnitsAction;

class AppendUnitsPermissionAggregator extends Aggregator
{
    /** @var \Afaqy\Permission\DTO\AppendUnitsData */
    private $data;

    /**
     * @param \Afaqy\Permission\DTO\AppendUnitsData  $data
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
        DB::transaction(function () use (&$permission) {
            $permission  = $this->data->model::where('permission_number', $this->data->number)->firstOrFail();

            (new StoreCheckinUnitsAction($this->data->units, $permission))->execute();
        });

        return $permission;
    }
}
