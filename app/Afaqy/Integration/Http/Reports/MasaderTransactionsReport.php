<?php

namespace Afaqy\Integration\Http\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Integration\Http\Transformers\MasaderDashboardTransformer;

class MasaderTransactionsReport extends Report
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
        $result = $this->query()->get();

        $data = $this->fractalCollection($result, new MasaderDashboardTransformer);

        return $this->returnSuccess('', $data);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $start = $this->request->date ?? Carbon::today();
        $end   = $this->request->date ? Carbon::parse($this->request->date)->addDay() : Carbon::tomorrow();

        return Dashboard::withUnits()
            ->select([
                'dashboard.id',
                'dashboard.start_time',
                'dashboard.end_time',
                'dashboard.plate_number',
                'dashboard.contractor_id',
                'dashboard.net_weight',
                DB::raw('dashboard.enterance_weight - dashboard.exit_weight as weight'),
                'units.waste_type_id',
            ])
            ->dateBetween($start, $end)
            ->tripCompleted()
            ->withoutSotringPermission();
    }
}
