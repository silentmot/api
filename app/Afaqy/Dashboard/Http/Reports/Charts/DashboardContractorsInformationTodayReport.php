<?php

namespace Afaqy\Dashboard\Http\Reports\Charts;

use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Http\Transformers\Charts\DboardContractorsInfoTodayTransformer;

class DashboardContractorsInformationTodayReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateSelectList(
            $this->query(),
            new DboardContractorsInfoTodayTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Dashboard::select([
            'contractor_id',
            'contractor_name',
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) as total_weights"),
        ])
            ->today()
            ->where('trip_type', 'contract')
            ->tripCompleted()
            ->groupBy(['contractor_id', 'contractor_name'])
            ->orderBy('total_weights', 'desc');
    }
}
