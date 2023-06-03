<?php

namespace Afaqy\Dashboard\Http\Reports\Violations;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\Dashboard\Facades\ReportPeriod;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\ViolationsReportFilter;
use Afaqy\Dashboard\Http\Transformers\Violations\ViolationsDashboardReportTransformer;

class ViolationsDashboardReport extends Report
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
            'filter' => ViolationsReportFilter::class,
        ];

        return $this->generateViewList(
            $this->query(),
            new ViolationsDashboardReportTransformer,
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

        return Dashboard::withCommonViolationsTranslation()
            ->select([
                'violations_logs.violation_time as date',
                'dashboard.plate_number',
                'dashboard.unit_code',
                'violations_logs.violation_type',
                'notifications.display_name as ar_violation_type',
                'dashboard.contractor_name',
                'dashboard.contract_number',
                'dashboard.permission_id',
                'dashboard.permission_type',
                'dashboard.enterance_weight',
                'dashboard.exit_weight',
            ])
            ->whereBetween('violation_time', [
                Carbon::parse($start)->getTimestamp(),
                Carbon::parse($end)->getTimestamp(),
            ])
            ->orderBy('date', 'desc');
    }
}
