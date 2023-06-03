<?php

namespace Afaqy\TripWorkflow\Actions\UnitInformation;

use Afaqy\Core\Actions\Action;

class GetUnitCheckerAction extends Action
{
    /**
     * @var \Afaqy\TripWorkflow\DTO\CarData
     */
    private $data;

    /**
     * @param \Afaqy\TripWorkflow\DTO\CarData $data
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
        // @TODO: remove this comments

        // get the most unique checker first
        if ($this->data->device_type == 'QR' && $this->data->qr_number) {
            return [
                'field' => 'qr_code',
                'value' => $this->data->qr_number,
            ];
        }

        if ($this->data->device_type == 'RFID' && $this->data->card_number) {
            return [
                'field' => 'rfid',
                'value' => $this->data->card_number,
            ];
        }

        return [
            'field' => 'plate_number',
            'value' => $this->data->car_number,
        ];
    }
}
