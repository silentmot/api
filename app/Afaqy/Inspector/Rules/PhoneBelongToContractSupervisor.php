<?php

namespace Afaqy\Inspector\Rules;

use Carbon\Carbon;
use Afaqy\Contract\Models\Contract;
use Illuminate\Contracts\Validation\Rule;

class PhoneBelongToContractSupervisor implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $date = Carbon::now()->toDateString();

        return (bool) Contract::withContactsInformation()
            ->where('contracts.start_at', '<=', $date)
            ->where('contracts.end_at', '>=', $date)
            ->where('contracts.status', 1)
            ->where('phones.phone', $value)
            ->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('inspector::inspector.phone-does-not-exist');
    }
}
