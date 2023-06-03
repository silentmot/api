<?php

namespace Afaqy\TripWorkflow\Actions\Entrance;

use Afaqy\Core\Actions\Action;
use Afaqy\Geofence\Models\Geofence;

class GetRegisteredGeofenceAction extends Action
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
        return Geofence::withCommonWasteTypes()
            ->select([
                'geofences.id',
                'geofences.name',
                'geofences.type',
            ])
            ->where('waste_types.name', $this->waste_type)
            ->whereNull('waste_types.deleted_at')
            ->get()
            ->toArray();
    }
}
