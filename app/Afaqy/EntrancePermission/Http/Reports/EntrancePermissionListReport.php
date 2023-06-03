<?php

namespace Afaqy\EntrancePermission\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\EntrancePermission\Models\EntrancePermission;
use Afaqy\EntrancePermission\Http\Transformers\EntrancePermissionTransformer;

class EntrancePermissionListReport extends Report
{
    use Generator;

    /**
     * @var \Illuminate\Http\Request $request
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
        $options['include'] = ['unitsCount'];

        return $this->generateViewList(
            $this->query(),
            new EntrancePermissionTransformer,
            $this->request,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = EntrancePermission::query();
        $query->sortBy($this->request);

        return $query;
    }
}
