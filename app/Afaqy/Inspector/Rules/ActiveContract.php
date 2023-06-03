<?php

namespace Afaqy\Inspector\Rules;

use Afaqy\Contract\Models\Contract;
use Illuminate\Contracts\Validation\Rule;

class ActiveContract implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param int $contract_id
     * @return bool
     */
    public function passes($attribute, $contract_id)
    {
        return Contract::activeContract()
            ->where('id', $contract_id)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('inspector::inspector.contract-does-not-exist');
    }
}
