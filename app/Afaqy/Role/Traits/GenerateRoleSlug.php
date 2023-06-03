<?php

namespace Afaqy\Role\Traits;

use Afaqy\Role\Models\Role;
use Illuminate\Support\Str;

trait GenerateRoleSlug
{
    /**
     * @param  string $role_name
     * @return string
     */
    protected function generateSlug(string $role_name): string
    {
        $slug = Str::slug($role_name);

        return ($this->isSlugExists($slug))
                ? $slug . '-' . time()
                : $slug;
    }

    /**
     * @param  string  $slug
     * @return boolean
     */
    protected function isSlugExists(string $slug): bool
    {
        return (bool) Role::where('name', $slug)->count();
    }
}
