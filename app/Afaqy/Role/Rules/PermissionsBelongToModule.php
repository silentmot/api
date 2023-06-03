<?php

namespace Afaqy\Role\Rules;

use Afaqy\Role\Models\Permission;
use Illuminate\Contracts\Validation\Rule;

class PermissionsBelongToModule implements Rule
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
        $module = explode('.', $attribute)[1];
        $module = strtr($module, '_', '-');

        $result = Permission::where('module', '!=', $module)
            ->whereIn('id', $value)
            ->count();

        return (bool) !$result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('role::role.permissions_not_belong_to_module');
    }
}
