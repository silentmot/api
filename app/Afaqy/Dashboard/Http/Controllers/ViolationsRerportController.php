<?php

namespace Afaqy\Dashboard\Http\Controllers;

use Illuminate\Http\Response;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Dashboard\Http\Requests\ViolationsRerportsRequest;
use Afaqy\Dashboard\Http\Reports\Violations\ViolationsDashboardReport;
use Afaqy\Dashboard\Http\Reports\Violations\ViolationsDashboardPdfReport;
use Afaqy\Dashboard\Http\Reports\Violations\ViolationsDashboardExcelReport;

class ViolationsRerportController extends Controller
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
                'prop'  => 'date',
                'name'  => 'التاريخ',
                'unit'  => null,
            ],
            [
                'prop'  => 'plate_number',
                'name'  => 'رقم اللوحة',
                'unit'  => null,
            ],
            [
                'prop'  => 'unit_code',
                'name'  => 'رمز المركبة',
                'unit'  => null,
            ],
            [
                'prop'  => 'violation_type',
                'name'  => 'نوع المخالفة',
                'unit'  => null,
            ],
            [
                'prop'  => 'contractor_name',
                'name'  => 'المقاول',
                'unit'  => null,
            ],
            [
                'prop'  => 'contract_number',
                'name'  => 'رقم العقد',
                'unit'  => null,
            ],
            [
                'prop'  => 'permission_id',
                'name'  => 'رقم التصريح',
                'unit'  => null,
            ],
            [
                'prop'  => 'permission_type',
                'name'  => 'نوع التصريح',
                'unit'  => null,
            ],
            [
                'prop'  => 'checkin_weight',
                'name'  => 'وزن الدخول',
                'unit'  => 'ton',
            ],
            [
                'prop'  => 'checkout_weight',
                'name'  => 'وزن الخروج',
                'unit'  => 'ton',
            ],
            [
                'prop'  => 'waste_weight',
                'name'  => 'وزن النفاية',
                'unit'  => 'ton',
            ],
        ];

        return $this->returnSuccess('', $headers);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function report(ViolationsRerportsRequest $request)
    {
        return (new ViolationsDashboardReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function exportExcel(ViolationsRerportsRequest $request)
    {
        return (new ViolationsDashboardExcelReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function exportPdf(ViolationsRerportsRequest $request)
    {
        return (new ViolationsDashboardPdfReport($request))->show();
    }
}
