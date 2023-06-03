<?php

namespace Afaqy\WasteType\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\WasteType\Models\WasteType;

class UpdateWasteTypeAction extends Action
{
    /** @var \Afaqy\WasteType\DTO\WasteTypeData */
    private $data;

    /**
     * @param \Afaqy\WasteType\DTO\WasteTypeData  $data
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
        $wastType = WasteType::withoutMardamWasteTypes()->findOrFail($this->data->id);

        $wastType->name    = $this->data->name;
        $wastType->zone_id = $this->data->zone_id;
        $wastType->pit_id  = $this->data->pit_id;

        $wastType->zones()->detach();

        $wastType->zones()->attach($this->data->scale_zones);

        return $wastType->update();
    }
}
