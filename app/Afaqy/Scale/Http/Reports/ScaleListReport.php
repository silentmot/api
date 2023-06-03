<?php

namespace Afaqy\Scale\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Scale\Models\Scale;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Scale\Http\Transformers\ScaleTransformer;

class ScaleListReport extends Report
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
            new ScaleTransformer,
            $this->request
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Scale::select([
            'scales.id',
            'scales.name',
            'ip',
            'com_port',
        ])->sortBy($this->request);
    }
}
