<?php

namespace Afaqy\Permission\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckQrCodeDuplication implements Rule
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
        $units = request()->all()['units'];

        $index = (int) explode('.', $attribute)[1];

        foreach ($units as $key => $unit) {
            if ($key == $index) {
                continue;
            }

            if ($unit['qr_code'] == $value) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('permission::permission.qrcode-duplication-found');
    }
}
