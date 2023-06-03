<?php

namespace Afaqy\TransitionalStation\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\TransitionalStation\Models\TransitionalStation;

class UpdateTransitionalStationAction extends Action
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
        $station = TransitionalStation::findOrFail($this->data->id);

        $result = $station->update([
            'name'   => $this->data->name,
            'status' => $this->data->status,
        ]);

        $station->districts()->sync($this->data->districts);


        return $result;
    }
}
