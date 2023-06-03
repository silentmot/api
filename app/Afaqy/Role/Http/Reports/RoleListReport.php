<?php

namespace Afaqy\Role\Http\Reports;

use Afaqy\Role\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Role\Http\Transformers\RoleTransformer;

class RoleListReport extends Report
{
    use Generator;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        $options['include'] = ['usersCount'];

        return $this->generateViewList(
            $this->query(),
            new RoleTransformer,
            $this->request,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = Role::withUnDeletedUsers();

        $query->select([
            'roles.id',
            'roles.display_name as display_name',
            DB::raw('COUNT(users.id) as users_count'),
        ])
            ->groupBy(['roles.id', 'roles.display_name'])
            ->sortBy($this->request);

        return $query;
    }
}
