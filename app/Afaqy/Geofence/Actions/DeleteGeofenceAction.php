<?php

namespace Afaqy\Geofence\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\Geofence\Models\Geofence;

class DeleteGeofenceAction extends Action
{
    /** @var mixed */
    private $id;

    /**
     * @param mixed  $id
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        if (is_array($this->id)) {
            return $this->deleteMany($this->id);
        }

        return $this->delete($this->id);
    }

    /**
     * @param  array  $ids
     * @return int
     */
    private function deleteMany(array $ids): int
    {
        if ($this->isHasRelatedWasteTypes($ids)) {
            return 0;
        }

        return Geofence::destroy($ids);
    }

    /**
     * @param  int  $id
     * @return int
     */
    private function delete(int $id): int
    {
        $geofence = Geofence::findOrFail($id);

        if ($this->isHasRelatedWasteTypes((array) $geofence->id)) {
            return 0;
        }

        return $geofence->delete();
    }

    /**
     * @param  $id
     * @return boolean
     */
    private function isHasRelatedWasteTypes($ids): bool
    {
        $query = Geofence::withCommonWasteTypes();

        $query->whereIn('geofences.id', (array) $ids)->whereNull('waste_types.deleted_at');

        if ($query->count()) {
            return true;
        }

        return false;
    }
}
