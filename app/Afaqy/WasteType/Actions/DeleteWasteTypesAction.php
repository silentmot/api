<?php

namespace Afaqy\WasteType\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\WasteType\Models\WasteType;

class DeleteWasteTypesAction extends Action
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
        if ($this->isHasRelatedUnits($ids)) {
            return 0;
        }

        return WasteType::destroy($ids);
    }

    /**
     * @param  int  $id
     * @return int
     */
    private function delete(int $id): int
    {
        $wasteType = WasteType::withoutMardamWasteTypes()->findOrFail($id);

        if ($this->isHasRelatedUnits($wasteType->id)) {
            return 0;
        }

        return $wasteType->delete();
    }

    /**
     * @param  $id
     * @return boolean
     */
    private function isHasRelatedUnits($ids): bool
    {
        $query = WasteType::withoutMardamWasteTypes()->withCommonUnits();

        $query->whereIn('waste_types.id', (array) $ids)->whereNull('units.deleted_at');

        if ($query->get()->count()) {
            return true;
        }

        return false;
    }
}
