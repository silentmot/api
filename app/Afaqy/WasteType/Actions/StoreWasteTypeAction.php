<?php

namespace Afaqy\WasteType\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\WasteType\Models\WasteType;

class StoreWasteTypeAction extends Action
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
        $waste_type =WasteType::create($this->data->toArray());

        $waste_type->zones()->attach($this->data->scale_zones);

        return $waste_type;
    }
}
