<?php

namespace Afaqy\Dashboard\Http\Controllers;

use Illuminate\Http\Response;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Dashboard\Http\Requests\WasteTypesRerportsRequest;
use Afaqy\Dashboard\Http\Reports\WasteTypes\WasteTypesChartReport;
use Afaqy\Dashboard\Http\Reports\WasteTypes\WasteTypesDashboardReport;
use Afaqy\Dashboard\Http\Reports\WasteTypes\WasteTypesTotalWeightReport;
use Afaqy\Dashboard\Http\Reports\WasteTypes\WasteTypesDashboardPdfReport;
use Afaqy\Dashboard\Http\Reports\WasteTypes\WasteTypesDashboardExcelReport;
use Afaqy\Dashboard\Http\Reports\WasteTypes\WasteTypesDashboardHeaderReport;

class WasteTypesRerportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function wasteTypesHeader(WasteTypesRerportsRequest $request)
    {
        return (new WasteTypesDashboardHeaderReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function wasteTypesRerport(WasteTypesRerportsRequest $request)
    {
        return (new WasteTypesDashboardReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function wasteTypesExcelExport(WasteTypesRerportsRequest $request)
    {
        return (new WasteTypesDashboardExcelReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function wasteTypesPdfExport(WasteTypesRerportsRequest $request)
    {
        return (new WasteTypesDashboardPdfReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function totalWeight(WasteTypesRerportsRequest $request)
    {
        return (new WasteTypesTotalWeightReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function chart(WasteTypesRerportsRequest $request)
    {
        return (new WasteTypesChartReport($request))->show();
    }
}
