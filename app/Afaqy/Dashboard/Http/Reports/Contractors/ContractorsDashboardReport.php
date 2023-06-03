<?php

namespace Afaqy\Dashboard\Http\Reports\Contractors;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\Dashboard\Facades\ReportPeriod;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Facades\ConvertTimezone;
use Afaqy\Dashboard\Models\Filters\ContractorReportFilter;
use Afaqy\Dashboard\Http\Transformers\Contractors\ContractorsDashboardRerportTransformer;

class ContractorsDashboardReport extends Report
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
            'filter' => ContractorReportFilter::class,
        ];

        return $this->generateViewList(
            $this->query(),
            new ContractorsDashboardRerportTransformer,
            $this->request,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        // I use subQuery because I can't paginate except this way, also
        // I want to convert query row result to columns header, so I make
        // the subQuery in this way to solve this problem.
        // Please check this report design.
        return Dashboard::from($this->subQueryTable(), 'contractors_report')
            ->select([
                'date',
                'contractor_name',
                DB::raw("GROUP_CONCAT(CONCAT(waste_type, ':', total_weight) ORDER BY waste_type ASC SEPARATOR ',') as waste_weights"),
            ])
            ->groupBy(['contractor_name', 'date'])
            ->orderBy('date', 'desc')
            ->orderBy('contractor_name', 'asc');
    }

    /**
     * Create subQuery table
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function subQueryTable()
    {
        [$start, $end] = ReportPeriod::get($this->request);
        $type          = $this->request->type ?? 'daily';

        $function = 'get' . ucfirst(trim($type)) . 'Columns';
        $columns  = $this->{$function}();

        return Dashboard::select($columns['select'])
            ->dateBetween($start, $end)
            ->whereNotNull('contractor_name')
            ->tripCompleted()
            ->groupBy($columns['group']);
    }

    /**
     * @return array
     */
    private function getDailyColumns()
    {
        $columns['select'] = [
            DB::raw(ConvertTimezone::column('start_time')->as('date')->format('%Y-%m-%d')->toString()),
            'contractor_name',
            'waste_type',
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) AS total_weight"),
        ];

        $columns['group'] = [
            DB::raw(ConvertTimezone::column('start_time')->format('%Y-%m-%d')->toString()),
            'contractor_name',
            'waste_type',
        ];

        return $columns;
    }

    /**
     * @return array
     */
    private function getWeeklyColumns()
    {
        $columns['select'] = [
            DB::raw("CONCAT(`year`, '-', `month`, '-', `week`) AS date"),
            'contractor_name',
            'waste_type',
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) AS total_weight"),
        ];

        $columns['group'] = [
            DB::raw("CONCAT(`year`, '-', `month`, '-', `week`)"),
            'contractor_name',
            'waste_type',
        ];

        return $columns;
    }

    /**
     * @return array
     */
    private function getMonthlyColumns()
    {
        $columns['select'] = [
            DB::raw("CONCAT(`year`, '-', `month`) AS date"),
            'contractor_name',
            'waste_type',
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) AS total_weight"),
        ];

        $columns['group'] = [
            DB::raw("CONCAT(`year`, '-', `month`)"),
            'contractor_name',
            'waste_type',
        ];

        return $columns;
    }
}
