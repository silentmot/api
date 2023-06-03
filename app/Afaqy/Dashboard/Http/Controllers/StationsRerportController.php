<?php

namespace Afaqy\Dashboard\Http\Controllers;

use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Dashboard\Http\Requests\StationsRerportsRequest;
use Afaqy\Dashboard\Http\Reports\Stations\StationsChartReport;
use Afaqy\Dashboard\Http\Reports\Stations\StationsDashboardReport;
use Afaqy\Dashboard\Http\Reports\Stations\StationsTotalWeightReport;
use Afaqy\Dashboard\Http\Reports\Stations\StationsDashboardPdfReport;
use Afaqy\Dashboard\Http\Reports\Stations\StationsDashboardExcelReport;

class StationsRerportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function header()
    {
        // we return table header static, because of front-end component.
        // You can remove this method anytime if no longer need it.
        $headers = [
            [
                'prop' => 'date',
                'name' => 'التاريخ',
                'unit' => null,
            ],
            [
                'prop' => 'station',
                'name' => 'المحطة الانتقالية',
                'unit' => null,
            ],
            [
                'prop' => 'contract_number',
                'name' => 'رقم العقد',
                'unit' => null,
            ],
            [
                'prop' => 'total_weight',
                'name' => 'وزن النفايات بالطن',
                'unit' => 'ton',
            ],
        ];

        return $this->returnSuccess('', $headers);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function report(StationsRerportsRequest $request)
    {
        return (new StationsDashboardReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function stationsExcelExport(StationsRerportsRequest $request)
    {
        return (new StationsDashboardExcelReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function stationsPdfExport(StationsRerportsRequest $request)
    {
        return (new StationsDashboardPdfReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function totalWeight(StationsRerportsRequest $request)
    {
        return (new StationsTotalWeightReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function chart(StationsRerportsRequest $request)
    {
        return (new StationsChartReport($request))->show();
    }
}
