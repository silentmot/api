<?php

namespace Afaqy\Gate\Http\Reports;

use Afaqy\Gate\Models\Gate;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Gate\Http\Transformers\GateTransformer;

class GateListReport extends Report
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
        return $this->generateViewList(
            $this->query(),
            new GateTransformer,
            $this->request
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Gate::select(['id', 'name', 'serial', 'direction'])->sortBy($this->request);
    }
}
