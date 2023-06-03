<?php

namespace Afaqy\Dashboard\Http\Reports\Charts;

use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Http\Transformers\Charts\DboardWasteTypesInfoTodayTransformer;

class DashboardWasteTypesInformationTodayReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateSelectList(
            $this->query(),
            new DboardWasteTypesInfoTodayTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Dashboard::select([
            'waste_type',
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) as total_weights"),
        ])
            ->today()
            ->withoutSotringPermission()
            ->tripCompleted()
            ->groupBy('waste_type')
            ->orderBy('total_weights', 'desc');
    }
}
