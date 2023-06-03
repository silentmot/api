<?php

namespace Afaqy\Permission\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Permission\Models\PermitUnit;

class UpdatePermissionUnitAction extends Action
{
    /** @var \Afaqy\Permission\DTO\UnitData */
    private $data;

    /** @var int */
    private $qr_code;

    /**
     * @param \Afaqy\Permission\DTO\UnitData $data
     * @param int $qr_code
     * @return void
     */
    public function __construct($data, $qr_code)
    {
        $this->data    = $data;
        $this->qr_code = $qr_code;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $has_trip = Dashboard::where('qr_code', $this->qr_code)->count();

        if ($has_trip) {
            return false;
        }

        return PermitUnit::where('qr_code', $this->qr_code)->update($this->data->toArray());
    }
}
