<?php

namespace Afaqy\Inspector\Rules;

use Afaqy\District\Models\Neighborhood;
use Illuminate\Contracts\Validation\Rule;

class ContractRelatedToNeighborhood implements Rule
{
    /**
     * @var int
     */
    public $neighborhood_id;

    /**
     * @param int $neighborhood_id
     * @return void
     */
    public function __construct(int $neighborhood_id)
    {
        $this->neighborhood_id = $neighborhood_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param int $contract_id
     * @return bool
     */
    public function passes($attribute, $contract_id)
    {
        return Neighborhood::withContracts()
            ->where('contract_district.contract_id', $contract_id)
            ->where('contract_district.neighborhood_id', $this->neighborhood_id)
            ->whereNull('neighborhoods.deleted_at')
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('inspector::inspector.contract-not-related-to-neighborhood');
    }
}
