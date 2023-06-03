<?php

namespace Afaqy\Unit\Actions;

use Afaqy\Unit\Models\Unit;
use Afaqy\Core\Actions\Action;

class DeleteUnitAction extends Action
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
        if ($this->isHasRelatedActiveContracts($ids)) {
            return 0;
        }

        return Unit::destroy($ids);
    }

    /**
     * @param  int  $id
     * @return int
     */
    private function delete(int $id): int
    {
        $unit = Unit::findOrFail($id);

        if ($this->isHasRelatedActiveContracts((array) $unit->id)) {
            return 0;
        }

        return $unit->delete();
    }

    /**
     * @param array $ids
     * @return bool
     */
    private function isHasRelatedActiveContracts(array $ids): bool
    {
        $district = (bool) Unit::whereContractsActive($ids)->count();

        if ($district) {
            return true;
        }

        $station = (bool) Unit::whereStationContractsActive($ids)->count();

        return $station;
    }
}
