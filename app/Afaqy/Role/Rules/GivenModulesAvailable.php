<?php

namespace Afaqy\Role\Rules;

use Afaqy\Role\Models\Permission;
use Illuminate\Contracts\Validation\Rule;

class GivenModulesAvailable implements Rule
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
        $modules    = [];
        $db_modules = Permission::distinct()->select('module')->get()->pluck('module')->toArray();

        foreach ($value as $key => $module) {
            $modules[] = strtr($key, '_', '-');
        }

        $diff = array_diff($modules, $db_modules);

        return empty($diff) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('role::role.given_modules_not_available');
    }
}
