<?php

namespace Afaqy\Role\Http\Reports;

use Afaqy\Role\Models\Permission;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Role\Http\Transformers\RolePermissionsTransformer;

class RolePermissionsReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateJoinViewShow(
            $this->query(),
            new RolePermissionsTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Permission::query();
    }
}
