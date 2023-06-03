<?php

namespace Afaqy\Role\Http\Reports;

use Afaqy\Role\Models\Role;
use Afaqy\Role\Models\Permission;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Role\Http\Transformers\RoleShowTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleShowReport extends Report
{
    use Generator;

    /**
     * @var int
     */
    private $id;

    /**
     * @param int $id
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        // @TODO: refactor this report
        $result = $this->query()->get();

        if ($result->isEmpty()) {
            throw new ModelNotFoundException;
        }

        $data                  = $this->fractalItem($result, new RoleShowTransformer, ['permissions']);
        $data['notifications'] = Role::find($this->id)->notifications()->get()->pluck('id')->all();

        return $this->returnSuccess('', $data);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Permission::withRolesIds($this->id)
            ->select([
                'permissions.id',
                'permissions.name',
                'permissions.display_name',
                'permissions.module',
                DB::raw($this->id . ' as role_id'),
                DB::raw('(SELECT display_name from roles where id = ' . $this->id . ') AS `role_name`'),
                DB::raw('IF(permission_role.permission_id, true, false) as is_selected'),
            ])
            ->havingRaw('role_name IS NOT NULL')
            ->orderBy('permissions.id');
    }
}
