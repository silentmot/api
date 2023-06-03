<?php

namespace Afaqy\User\Http\Reports;

use Afaqy\User\Models\User;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\User\Http\Transformers\UserProfileTransformer;

class UserShowProfileReport extends Report
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
        return $this->generateViewShow(
            $this->query(),
            new UserProfileTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = User::select([
            'users.id as user_id',
            'users.username',
            'users.first_name',
            'users.last_name',
            DB::raw('CONCAT(first_name, " ",last_name) as full_name'),
            'users.email',
            'users.phone',
            'users.status',
            'users.avatar',
        ]);
        $query->where('users.id', $this->id);

        return $query;
    }
}
