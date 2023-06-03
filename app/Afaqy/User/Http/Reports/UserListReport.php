<?php

namespace Afaqy\User\Http\Reports;

use Afaqy\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\User\Http\Transformers\UserTransformer;

class UserListReport extends Report
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
        $options['include'] = ['role'];

        return $this->generateViewList(
            $this->query(),
            new UserTransformer,
            $this->request,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = User::withRoles();

        $query->select([
            'users.id as user_id',
            'users.username',
            DB::raw('CONCAT(first_name, " ",last_name) as full_name'),
            'users.email',
            'users.phone',
            'users.status',
            'users.avatar',
            'users.use_mob',
            'roles.display_name as role',
        ])->sortBy($this->request);

        return $query;
    }
}
