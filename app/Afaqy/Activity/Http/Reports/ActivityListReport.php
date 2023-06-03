<?php

namespace Afaqy\Activity\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Activity\Models\Activity;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Activity\Http\Transformers\ActivitiesTransformer;

class ActivityListReport extends Report
{
    use Generator;

    /**
     * @var Request $request
     */
    private $request;

    /**
     * @param Request $request
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
            new ActivitiesTransformer,
            $this->request
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Activity::with(['causer'])
            ->sortBy($this->request);
    }
}
