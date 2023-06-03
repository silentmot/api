<?php

namespace Afaqy\Permission\Http\Reports;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Permission\Http\Transformers\SerialsTransformer;

class PermissionSerialsReport extends Report
{
    use Generator;

    /**
     * @var mixed
     */
    private $model;

    /**
     * @param  mixed  $model
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateSelectList(
            $this->query(),
            new SerialsTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return $this->model::select('permission_number');
    }
}
