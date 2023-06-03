<?php

namespace Afaqy\Dashboard\Http\Reports\Stations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\Dashboard\Facades\ReportPeriod;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Facades\ConvertTimezone;
use Afaqy\Dashboard\Models\Filters\StationsReportFilter;
use Afaqy\Dashboard\Http\Transformers\Stations\StationsDashboardReportTransformer;

class StationsDashboardReport extends Report
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
            'filter' => StationsReportFilter::class,
        ];

        return $this->generateViewList(
            $this->query(),
            new StationsDashboardReportTransformer,
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
        $type          = $this->request->type ?? 'daily';

        // TODO: need to refactor and get better solution
        $function = 'get' . ucfirst(trim($type)) . 'Columns';
        $columns  = $this->{$function}();

        return Dashboard::select($columns['select'])
            ->dateBetween($start, $end)
            ->whereNotNull('station_name')
            ->tripCompleted()
            ->groupBy($columns['group'])
            ->orderBy('date', 'desc')
            ->orderBy('station_name', 'asc');
    }

    /**
     * @return array
     */
    private function getDailyColumns()
    {
        $columns['select'] = [
            DB::raw(ConvertTimezone::column('start_time')->as('date')->format('%Y-%m-%d')->toString()),
            'station_name',
            'contract_number',
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) AS total_weight"),
        ];

        $columns['group'] = [
            DB::raw(ConvertTimezone::column('start_time')->format('%Y-%m-%d')->toString()),
            'station_name',
            'contract_number',
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
            'station_name',
            'contract_number',
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) AS total_weight"),
        ];

        $columns['group'] = [
            DB::raw("CONCAT(`year`, '-', `month`, '-', `week`)"),
            'station_name',
            'contract_number',
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
            'station_name',
            'contract_number',
            DB::raw("SUM(`enterance_weight`) - SUM(`exit_weight`) AS total_weight"),
        ];

        $columns['group'] = [
            DB::raw("CONCAT(`year`, '-', `month`)"),
            'station_name',
            'contract_number',
        ];

        return $columns;
    }
}
