<?php

namespace Afaqy\Core\Http\Reports;

use Illuminate\Database\Eloquent\Builder;
use Afaqy\Core\Http\Responses\ResponseBuilder;
use Afaqy\Core\Http\Transformers\FractalBuilder;

abstract class Report
{
    use FractalBuilder;
    use ResponseBuilder;

    /**
     * @return mixed
     */
    public function show()
    {
        if (method_exists($this, 'getCache')) {
            return $this->getCache();
        }

        return $this->generate();
    }

    /**
     * Report query builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    abstract public function query(): Builder;

    /**
     * Returned data from the report
     *
     * @return mixed
     */
    abstract public function generate();
}
