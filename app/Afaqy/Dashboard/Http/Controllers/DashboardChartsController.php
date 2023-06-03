<?php

namespace Afaqy\Dashboard\Http\Controllers;

use Illuminate\Http\Response;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Dashboard\Http\Reports\Charts\DashboardLastWeekTotalWeightsReport;
use Afaqy\Dashboard\Http\Reports\Charts\DashboardTotalSystemInformationReport;
use Afaqy\Dashboard\Http\Reports\Charts\DashboardWeightsCountPerHourTodayReport;
use Afaqy\Dashboard\Http\Reports\Charts\DashboardTotalYesterdayInformationReport;
use Afaqy\Dashboard\Http\Reports\Charts\DashboardWasteTypesInformationTodayReport;
use Afaqy\Dashboard\Http\Reports\Charts\DashboardContractorsInformationTodayReport;

class DashboardChartsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function totalSystemInformation()
    {
        return (new DashboardTotalSystemInformationReport)->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function totalYesterdayInformation()
    {
        return (new DashboardTotalYesterdayInformationReport)->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function todayContractorsInformation()
    {
        return (new DashboardContractorsInformationTodayReport)->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function todayWasteTypesInformation()
    {
        return (new DashboardWasteTypesInformationTodayReport)->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function todayWeightsCountPerHour()
    {
        return (new DashboardWeightsCountPerHourTodayReport)->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function lastWeekTotalWeights()
    {
        return (new DashboardLastWeekTotalWeightsReport)->show();
    }
}
