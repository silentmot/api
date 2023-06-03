<?php

namespace Afaqy\Role\Http\Reports;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\Role\Models\Notification;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Role\Http\Transformers\NotificationTransformer;

class NotificationsListReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateSelectList(
            $this->query(),
            new NotificationTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Notification::query();
    }
}
