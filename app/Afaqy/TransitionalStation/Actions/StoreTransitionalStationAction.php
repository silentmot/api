<?php

namespace Afaqy\TransitionalStation\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\TransitionalStation\Models\TransitionalStation;

class StoreTransitionalStationAction extends Action
{
    /** @var \Afaqy\TransitionalStation\DTO\TransitionalStationData */
    private $data;

    /**
     * @param \Afaqy\TransitionalStation\DTO\TransitionalStationData  $data
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
        $station = TransitionalStation::create($this->data->toArray());

        $station->districts()->attach($this->data->districts);

        return $station;
    }
}
