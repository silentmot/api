<?php

namespace Afaqy\EntrancePermission\Http\Reports;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\EntrancePermission\Models\EntrancePermission;
use Afaqy\EntrancePermission\Http\Transformers\EntrancePermissionShowTransformer;

class EntrancePermissionShowReport extends Report
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
    public function __construct(int $id)
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
            new EntrancePermissionShowTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return EntrancePermission::where('entrance_permissions.id', $this->id);
    }
}
