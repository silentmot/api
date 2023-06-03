<?php

namespace Afaqy\Dashboard\Http\Controllers;

use Illuminate\Http\Response;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Dashboard\Http\Requests\DistrictsRerportsRequest;
use Afaqy\Dashboard\Http\Reports\Districts\DistrictsMapReport;
use Afaqy\Dashboard\Http\Reports\Districts\DistrictsChartReport;
use Afaqy\Dashboard\Http\Reports\Districts\DistrictsDashboardReport;
use Afaqy\Dashboard\Http\Reports\Districts\DistrictsTotalWeightReport;
use Afaqy\Dashboard\Http\Reports\Districts\DistrictsDashboardPdfReport;
use Afaqy\Dashboard\Http\Reports\Districts\DistrictsDashboardExcelReport;
use Afaqy\Dashboard\Http\Reports\Districts\DistrictsDashboardHeaderReport;

class DistrictsRerportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function districtsHeader(DistrictsRerportsRequest $request)
    {
        return (new DistrictsDashboardHeaderReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function districtsRerport(DistrictsRerportsRequest $request)
    {
        return (new DistrictsDashboardReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function districtsExcelExport(DistrictsRerportsRequest $request)
    {
        return (new DistrictsDashboardExcelReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function districtsPdfExport(DistrictsRerportsRequest $request)
    {
        return (new DistrictsDashboardPdfReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function totalWeight(DistrictsRerportsRequest $request)
    {
        return (new DistrictsTotalWeightReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function chart(DistrictsRerportsRequest $request)
    {
        return (new DistrictsChartReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function mapRerport()
    {
        return (new DistrictsMapReport)->show();
    }
}
