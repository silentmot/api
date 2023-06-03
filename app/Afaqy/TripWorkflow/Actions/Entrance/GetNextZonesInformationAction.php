<?php

namespace Afaqy\TripWorkflow\Actions\Entrance;

use Afaqy\Zone\Models\Zone;
use Afaqy\Core\Actions\Action;
use Afaqy\WasteType\Models\WasteType;

class GetNextZonesInformationAction extends Action
{
    /**
     * @var string
     */
    private $waste_type;

    /**
     * @param string $waste_type
     * @return void
     */
    public function __construct(string $waste_type)
    {
        $this->waste_type = $waste_type;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $zone = WasteType::withZones()
            ->select([
                'zones.id',
                'zones.message_id',
            ])
            ->where('waste_types.name', $this->waste_type)
            ->first();

        if (!$zone || !$zone->id) {
            $zone = $this->defualtZone();
        }

        return [
            'sound' => $zone->message_id,
            'text'  => config('tripworkflow.message.' . $zone->message_id),
        ];
    }

    /**
     * @return array
     */
    private function defualtZone()
    {
        return Zone::select([
            'zones.id',
            'zones.message_id',
        ])
            ->where('type', 'entranceScale')
            ->first();
    }
}
