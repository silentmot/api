<?php

namespace Afaqy\Dashboard\Http\Reports\Units;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\Dashboard\Facades\ReportPeriod;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\UnitReportFilter;
use Afaqy\Dashboard\Http\Transformers\Units\UnitsDashboardRerportTransformer;

class UnitsDashboardReport extends Report
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
        $options = [
            'filter' => UnitReportFilter::class,
        ];

        return $this->generateViewList(
            $this->query(),
            new UnitsDashboardRerportTransformer,
            $this->request,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        [$start, $end] = ReportPeriod::get($this->request);

        return Dashboard::select([
            'unit_code',
            'plate_number',
            'contractor_name',
            'contract_number',
            'permission_id',
            'permission_type',
            'unit_type',
            'waste_type',
            'net_weight',
            'max_weight',
            'entrance_scale_name',
            'enterance_weight',
            'exit_scale_name',
            'exit_weight',
            DB::raw('enterance_weight - exit_weight as waste_weight'),
            'start_time',
            'end_time',
        ])
            ->dateBetween($start, $end)
            ->withoutSotringPermission()
            ->tripCompleted()
            ->orderBy('start_time', 'desc');
    }
}
