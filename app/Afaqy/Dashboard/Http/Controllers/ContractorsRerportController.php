<?php

namespace Afaqy\Dashboard\Http\Controllers;

use Illuminate\Http\Response;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Dashboard\Http\Requests\ContractorsRerportsRequest;
use Afaqy\Dashboard\Http\Reports\Contractors\ContractorsChartReport;
use Afaqy\Dashboard\Http\Reports\Contractors\ContractorsDashboardReport;
use Afaqy\Dashboard\Http\Reports\Contractors\ContractorsTotalWeightReport;
use Afaqy\Dashboard\Http\Reports\Contractors\ContractorsDashboardPdfReport;
use Afaqy\Dashboard\Http\Reports\Contractors\ContractorsDashboardExcelReport;
use Afaqy\Dashboard\Http\Reports\Contractors\ContractorsDashboardHeaderReport;

class ContractorsRerportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function contractorsHeader(ContractorsRerportsRequest $request)
    {
        return (new ContractorsDashboardHeaderReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function contractorsRerport(ContractorsRerportsRequest $request)
    {
        return (new ContractorsDashboardReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function contractorsExcelExport(ContractorsRerportsRequest $request)
    {
        return (new ContractorsDashboardExcelReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function contractorsPdfExport(ContractorsRerportsRequest $request)
    {
        return (new ContractorsDashboardPdfReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function totalWeight(ContractorsRerportsRequest $request)
    {
        return (new ContractorsTotalWeightReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function chart(ContractorsRerportsRequest $request)
    {
        return (new ContractorsChartReport($request))->show();
    }
}
