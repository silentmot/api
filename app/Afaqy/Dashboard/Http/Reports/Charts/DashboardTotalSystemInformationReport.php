<?php

namespace Afaqy\Dashboard\Http\Reports\Charts;

use Afaqy\Unit\Models\Unit;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Http\Transformers\Charts\DboardTotalSystemInfoTransformer;

class DashboardTotalSystemInformationReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateJoinViewShow(
            $this->query(),
            new DboardTotalSystemInfoTransformer,
            [],
            false
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $total_weight = Dashboard::select([
            DB::raw("'weights' as type"),
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) as total"),
        ])
            ->withoutSotringPermission()
            ->tripCompleted();

        return Unit::select([
            DB::raw("'units' as type"),
            DB::raw("COUNT('*') as total"),
        ])
            ->union($total_weight);
    }
}
