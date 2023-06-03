<?php

namespace Afaqy\User\Http\Reports;

use Afaqy\Role\Models\Permission;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\User\Http\Transformers\UserPermissionsTransformer;

class UserPermissionsReport extends Report
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
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateJoinViewShow(
            $this->query(),
            new UserPermissionsTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = Permission::select([
            'permissions.id',
            'permissions.name',
            'permissions.display_name',
            'permissions.module',
            DB::raw($this->id . ' as user_id'),
            DB::raw("
                CASE
                    WHEN(
                        SELECT
                            permission_role.permission_id
                        FROM
                            users
                        LEFT JOIN role_user ON role_user.user_id = users.id
                        LEFT JOIN permission_role ON permission_role.role_id = role_user.role_id
                        WHERE users.id = " . $this->id . " AND permission_role.permission_id = permissions.id
                    ) THEN TRUE
                    WHEN (
                        SELECT
                            role_user.role_id
                        FROM
                            role_user
                        WHERE
                            role_user.user_id = " . $this->id . " AND role_user.role_id = 1
                    ) THEN true
                    ELSE FALSE
                END AS is_selected
            "),
        ])
            ->orderBy('permissions.id');

        return $query;
    }
}
