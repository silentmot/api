<?php

namespace Afaqy\TripWorkflow\Actions\PostTrip;

use Afaqy\Core\Actions\Action;
use Afaqy\TripWorkflow\Models\PostTrip;

class StoreAvlUnitFinalDestinationAction extends Action
{
    /**
     * @var \Afaqy\TripWorkflow\DTO\AVLUnitFinalDestinaionData
     */
    private $data;

    /**
     * @param \Afaqy\TripWorkflow\DTO\AVLUnitFinalDestinaionData $data
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
        return PostTrip::create([
            'plate_number'     => $this->data->plate_number,
            'shift_id'         => $this->data->shift_id,
            'arrival_time'     => $this->data->arrival_time,
            'arrival_location' => $this->data->arrival_location,
        ]);
    }
}
