<?php

namespace Afaqy\Contact\Http\Reports;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;

class ContactListReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        # code...
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        # code...
    }
}
