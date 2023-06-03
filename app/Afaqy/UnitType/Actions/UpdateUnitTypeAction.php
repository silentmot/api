<?php

namespace Afaqy\UnitType\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\UnitType\Models\UnitType;

class UpdateUnitTypeAction extends Action
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
        $unitType = UnitType::findOrFail($this->data->id);

        $result = $unitType->update([
            'name' => $this->data->name,
        ]);

        if (! empty($this->data->waste_types)) {
            $unitType->wasteTypes()->sync($this->data->waste_types);
        }

        return $result;
    }
}
