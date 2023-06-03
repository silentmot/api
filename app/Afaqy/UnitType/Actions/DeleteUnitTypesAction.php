<?php

namespace Afaqy\UnitType\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\UnitType\Models\UnitType;

class DeleteUnitTypesAction extends Action
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
        if ($this->isHasRelatedUnitsOrWasteType($ids)) {
            return 0;
        }

        return UnitType::destroy($ids);
    }

    /**
     * @param  int  $id
     * @return int
     */
    private function delete(int $id): int
    {
        $unitType = UnitType::findOrFail($id);

        if ($this->isHasRelatedUnitsOrWasteType($unitType->id)) {
            return 0;
        }

        return $unitType->delete();
    }

    /**
     * @param  $ids
     * @return bool
     */
    private function isHasRelatedUnitsOrWasteType($ids): bool
    {
        $query = UnitType::withCommonUnits();

        $query->whereIn('unit_types.id', (array) $ids)->whereNull('units.deleted_at');

        if ($query->get()->count()) {
            return true;
        }

        return false;
    }
}
