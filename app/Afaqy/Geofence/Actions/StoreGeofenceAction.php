<?php

namespace Afaqy\Geofence\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\Geofence\Models\Geofence;

class StoreGeofenceAction extends Action
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
        return Geofence::create($this->data->toArray());
    }
}
