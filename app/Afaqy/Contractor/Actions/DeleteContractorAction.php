<?php

namespace Afaqy\Contractor\Actions;

use Afaqy\Unit\Models\Unit;
use Afaqy\Core\Actions\Action;
use Afaqy\Contract\Models\Contract;
use Afaqy\Contractor\Models\Contractor;

class DeleteContractorAction extends Action
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
        if ($this->isHasRelatedToContracts($ids)) {
            return 0;
        }

        if (! request()->has('confirmation') && $this->isHasUnits($ids)) {
            return -1;
        }

        Unit::whereIn('units.contractor_id', (array) $ids)->whereNull('units.deleted_at')->delete();

        return Contractor::destroy($ids);
    }

    /**
     * @param  int  $id
     * @return int
     */
    private function delete(int $id): int
    {
        $contractor = Contractor::findOrFail($id);

        if ($this->isHasRelatedToContracts($contractor->id)) {
            return 0;
        }
        if (! request()->has('confirmation') && $this->isHasUnits($id)) {
            return -1;
        }

        Unit::where('units.contractor_id', $id)->whereNull('units.deleted_at')->delete();

        return $contractor->delete();
    }

    /**
     * @param  $ids
     * @return bool
     */
    private function isHasRelatedToContracts($ids): bool
    {
        $queryContracts = Contract::join('contractors', 'contractors.id', 'contracts.contractor_id')
            ->whereIn('contractors.id', (array) $ids)->whereNull('contracts.deleted_at');

        if (($queryContracts->get()->count() > 0)) {
            return true;
        }

        return false;
    }

    /**
     * @param $ids
     * @return bool
     */
    public function isHasUnits($ids)
    {
        $units = Unit::whereIn('units.contractor_id', (array) $ids)->whereNull('units.deleted_at');

        return (bool) $units->count() ;
    }
}
