<?php

namespace Afaqy\Dashboard\Http\Reports\Charts;

use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Http\Transformers\Charts\DboardTotalYesterdayInfoTransformer;

class DashboardTotalYesterdayInformationReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateViewShow(
            $this->query(),
            new DboardTotalYesterdayInfoTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Dashboard::select([
            DB::raw("COUNT(DISTINCT `district_id`) as districts_count"),
            DB::raw("COUNT(`plate_number`) as units_count"),
            DB::raw("COUNT(DISTINCT `contractor_id`) as contractors_count"),
            DB::raw("COUNT(DISTINCT `waste_type`) as waste_types_count"),
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) as total_weights"),
        ])
            ->today()
            ->withoutSotringPermission()
            ->tripCompleted();
    }
}
