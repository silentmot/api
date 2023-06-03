<?php

namespace Afaqy\Activity\Models\Filters;

use Afaqy\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Core\Models\Filters\ModelFilter;

class ActivityFilter extends ModelFilter
{
    /**
     * @param $keyword
     * @return ActivityFilter
     */
    public function keyword($keyword): ActivityFilter
    {
        $actionName = $this->getActionName($keyword);

        return $this->whereHasMorph(
            'causer',
            [User::class],
            function (Builder $query) use ($keyword) {
                $query->where('username', 'like', '%' . $keyword . '%');
            }
        )->orWhere('description', 'like', '%' . $actionName . '%');
    }

    /**
     * @param $keyword
     * @return string
     */
    public function getActionName($keyword): string
    {
        $actionName = [
            'اضافه' => 'created',
            'تعديل' => 'updated',
            'حذف'   => 'deleted',
        ];

        return array_key_exists($keyword, $actionName) ? $actionName[$keyword] : '';
    }
}
