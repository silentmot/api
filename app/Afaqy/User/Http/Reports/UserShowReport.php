<?php

namespace Afaqy\User\Http\Reports;

use Afaqy\User\Models\User;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\User\Http\Transformers\UserShowTransformer;

class UserShowReport extends Report
{
    use Generator;

    /**
     * @var int $id
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
        return $this->generateViewShow(
            $this->query(),
            new UserShowTransformer,
            ['role']
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
            'users.first_name',
            'users.last_name',
            'users.email',
            'users.phone',
            'users.status',
            'users.use_mob',
            'roles.id as role',
        ])
            ->where('users.id', $this->id);

        return $query;
    }
}
