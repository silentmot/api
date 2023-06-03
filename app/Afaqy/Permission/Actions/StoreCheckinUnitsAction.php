<?php

namespace Afaqy\Permission\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\Permission\Models\PermitUnit;

class StoreCheckinUnitsAction extends Action
{
    /** @var \Afaqy\Permission\DTO\UnitData */
    private $data = [];

    /** @var object */
    private $checkinable;

    /**
     * @param mixed $data
     * @return void
     */
    public function __construct($data, $checkinable)
    {
        $this->data        = $data;
        $this->checkinable = $checkinable;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        // TO-Do: refactor
        foreach ($this->data as $unit) {
            $newUnit = PermitUnit::create([
                "plate_number" => $unit->plate_number,
                "qr_code"      => $unit->qr_code,
                "rfid"         => $unit->rfid,
            ]);

            $this->checkinable->checkinUnits()->create([
                "checkinable_id"     => $this->checkinable->id,
                "unit_id"            => $newUnit->id,
            ]);
        }

        return true;
    }
}
