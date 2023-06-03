<?php

namespace Afaqy\Dashboard\Http\Controllers;

use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Dashboard\Http\Requests\PerHourRerportsRequest;
use Afaqy\Dashboard\Http\Reports\PerHour\PerHourChartReport;
use Afaqy\Dashboard\Http\Reports\PerHour\PerHourDashboardReport;
use Afaqy\Dashboard\Http\Reports\PerHour\PerHourTotalWeightReport;
use Afaqy\Dashboard\Http\Reports\PerHour\PerHourDashboardPdfReport;
use Afaqy\Dashboard\Http\Reports\PerHour\PerHourDashboardExcelReport;

class PerHourRerportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function perHourHeader()
    {
        // we return table header static, because of front-end component.
        // You can remove this method anytime if no longer need it.
        $headers = [
            [
                'prop' => 'hour',
                'name' => 'الساعة',
                'unit' => null,
            ],
            [
                'prop' => 'date',
                'name' => 'التاريخ',
                'unit' => null,
            ],
            [
                'prop' => 'units_count',
                'name' => 'عدد المركبات',
                'unit' => 'unit',
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
    public function perHourRerport(PerHourRerportsRequest $request)
    {
        return (new PerHourDashboardReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function perHourExcelExport(PerHourRerportsRequest $request)
    {
        return (new PerHourDashboardExcelReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function perHourPdfExport(PerHourRerportsRequest $request)
    {
        return (new PerHourDashboardPdfReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function totalWeight(PerHourRerportsRequest $request)
    {
        return (new PerHourTotalWeightReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function chart(PerHourRerportsRequest $request)
    {
        return (new PerHourChartReport($request))->show();
    }
}
