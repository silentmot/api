<?php

namespace Afaqy\District\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\District\Models\District;

class DeleteDistrictsAction extends Action
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
        if ($this->isHasRelatedContract($ids)) {
            return 0;
        }

        if ($this->isHasRelatedStation($ids)) {
            return 0;
        }

        return District::destroy($ids);
    }

    /**
     * @param  int  $id
     * @return int
     */
    private function delete(int $id): int
    {
        $district = District::findOrFail($id);

        if ($this->isHasRelatedContract($id)) {
            return 0;
        }

        if ($this->isHasRelatedStation($id)) {
            return 0;
        }

        return $district->delete();
    }

    /**
     * @param  $id
     * @return boolean
     */
    private function isHasRelatedContract($ids): bool
    {
        $query = District::withCommonContractsIds()
            ->whereIn('districts.id', (array) $ids);

        if ($query->count()) {
            return true;
        }

        return false;
    }

    /**
     * @param  $id
     * @return boolean
     */
    private function isHasRelatedStation($ids): bool
    {
        $query = District::withCommonStations()
            ->whereIn('districts.id', (array) $ids)
            ->whereNull('transitional_stations.deleted_at');

        if ($query->count()) {
            return true;
        }

        return false;
    }
}
