<?php

namespace Afaqy\User\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;

class UserFilter extends ModelFilter
{
    /**
     * @param  string $keyword
     * @return UserFilter|\Illuminate\Database\Eloquent\Builder
     */
    public function keyword(string $keyword)
    {
        return $this->where('users.username', 'Like', '%' . $keyword . '%')
            ->orWhere('users.first_name', 'Like', '%' . $keyword . '%')
            ->orWhere('users.last_name', 'Like', '%' . $keyword . '%')
            ->orWhere('users.email', 'Like', '%' . $keyword . '%')
            ->orWhere('roles.name', 'Like', '%' . $keyword . '%');
    }
}
