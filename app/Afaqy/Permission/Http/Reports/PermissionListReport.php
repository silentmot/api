<?php

namespace Afaqy\Permission\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Permission\Http\Transformers\PermissionTransformer;

class PermissionListReport extends Report
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
        return $this->generateViewList(
            $this->query(),
            new PermissionTransformer,
            $this->request
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Permission::select('*')->sortBy($this->request);
    }
}
