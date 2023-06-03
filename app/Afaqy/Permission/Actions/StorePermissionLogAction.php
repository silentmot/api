<?php

namespace Afaqy\Permission\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\Permission\Models\PermissionLog;

class StorePermissionLogAction extends Action
{
    /** @var \Afaqy\Permission\DTO\CommercialPermissionData */
    private $data;

    /**
     * @param mixed $data
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
        $exisingLog = PermissionLog::where([
            'permission_number' => $this->data['permission_number'],
            'permission_type'   => $this->data['permission_type'],
        ])->first();

        $newActualWeight = ($this->data['actual_weight']) + ($exisingLog->actual_weight ?? 0);

        return PermissionLog::updateOrCreate([
            'permission_number' => $this->data['permission_number'],
            'permission_type'   => $this->data['permission_type'],
            'allowed_weight'    => $this->data['allowed_weight'],
        ], [
            'actual_weight' => $newActualWeight,
        ]);
    }
}
