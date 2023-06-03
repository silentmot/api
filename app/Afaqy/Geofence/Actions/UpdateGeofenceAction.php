<?php

namespace Afaqy\Geofence\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\Geofence\Models\Geofence;

class UpdateGeofenceAction extends Action
{
    /** @var \Afaqy\Geofence\DTO\GeofenceData */
    private $data;

    /**
     * @param \Afaqy\Geofence\DTO\GeofenceData  $data
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
        $wastType = Geofence::findOrFail($this->data->id);

        $wastType->name        = $this->data->name;
        $wastType->type        = $this->data->type;
        $wastType->geofence_id = $this->data->geofence_id;

        return $wastType->update();
    }
}
