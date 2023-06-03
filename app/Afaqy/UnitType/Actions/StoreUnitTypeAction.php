<?php

namespace Afaqy\UnitType\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\UnitType\Models\UnitType;

class StoreUnitTypeAction extends Action
{
    /** @var \Afaqy\UnitType\DTO\UnitTypeData */
    private $data;

    /**
     * @param \Afaqy\UnitType\DTO\UnitTypeData  $data
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
        $unit = UnitType::create($this->data->toArray());

        if (! empty($this->data->waste_types)) {
            $unit->wasteTypes()->sync($this->data->waste_types);
        }

        return $unit;
    }
}
