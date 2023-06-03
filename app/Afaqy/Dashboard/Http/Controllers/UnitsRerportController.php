<?php

namespace Afaqy\Dashboard\Http\Controllers;

use Illuminate\Http\Response;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Dashboard\Http\Requests\UnitsRerportsRequest;
use Afaqy\Dashboard\Http\Reports\Units\UnitsDashboardReport;
use Afaqy\Dashboard\Http\Reports\Units\UnitsTotalWeightReport;
use Afaqy\Dashboard\Http\Reports\Units\UnitsDashboardPdfReport;
use Afaqy\Dashboard\Http\Reports\Units\UnitsDashboardExcelReport;

class UnitsRerportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function unitsHeader()
    {
        // we return table header static, because of front-end component.
        // You can remove this method anytime if no longer need it.
        $headers = [
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
                'prop'  => 'unit_type',
                'name'  => 'نوع المركبة',
                'unit'  => null,
            ],
            [
                'prop'  => 'waste_type',
                'name'  => 'نوع النفاية',
                'unit'  => null,
            ],
            [
                'prop'  => 'net_weight',
                'name'  => 'الوزن الصافي',
                'unit'  => 'ton',
            ],
            [
                'prop'  => 'max_weight',
                'name'  => 'أقصي وزن',
                'unit'  => 'ton',
            ],
            [
                'prop'  => 'entrance_scale_name',
                'name'  => 'أسم ميزان الدخول',
                'unit'  => null,
            ],
            [
                'prop'  => 'checkin_weight',
                'name'  => 'وزن الدخول',
                'unit'  => 'ton',
            ],
            [
                'prop'  => 'exit_scale_name',
                'name'  => 'أسم ميزان الخروج',
                'unit'  => null,
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
            [
                'prop'  => 'checkin_time',
                'name'  => 'وقت الدخول',
                'unit'  => null,
            ],
            [
                'prop'  => 'checkout_time',
                'name'  => 'وقت الخروج',
                'unit'  => null,
            ],
            [
                'prop'  => 'duration',
                'name'  => 'مدة الرحلة',
                'unit'  => null,
            ],
        ];

        return $this->returnSuccess('', $headers);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function unitsReport(UnitsRerportsRequest $request)
    {
        return (new UnitsDashboardReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function unitsExcelExport(UnitsRerportsRequest $request)
    {
        return (new UnitsDashboardExcelReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function unitsPdfExport(UnitsRerportsRequest $request)
    {
        return (new UnitsDashboardPdfReport($request))->show();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function totalWeight(UnitsRerportsRequest $request)
    {
        return (new UnitsTotalWeightReport($request))->show();
    }
}
