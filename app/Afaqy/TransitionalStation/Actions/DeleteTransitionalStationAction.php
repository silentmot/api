<?php

namespace Afaqy\TransitionalStation\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\TransitionalStation\Models\TransitionalStation;

class DeleteTransitionalStationAction extends Action
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

        return TransitionalStation::destroy($ids);
    }

    /**
     * @param  int  $id
     * @return int
     */
    private function delete(int $id): int
    {
        $station = TransitionalStation::findOrFail($id);

        if ($this->isHasRelatedActiveContracts((array) $station->id)) {
            return 0;
        }

        return $station->delete();
    }

    /**
     * @param array $ids
     * @return bool
     */
    private function isHasRelatedActiveContracts(array $ids): bool
    {
        return (bool) TransitionalStation::whereContractsActive($ids)->count();
    }
}
