<?php

namespace Afaqy\Activity\Http\Reports;

use Afaqy\Activity\Models\Activity;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Activity\Http\Transformers\ActivityTransformer;

class ActivityShowReport extends Report
{
    use Generator;

    /**
     * @var int $id
     */
    private $id;

    /**
     * @param int $id
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
            new ActivityTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Activity::where('activity_log.id', $this->id);
    }
}
