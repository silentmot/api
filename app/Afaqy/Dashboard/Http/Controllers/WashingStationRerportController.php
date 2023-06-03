<?php

namespace Afaqy\Dashboard\Http\Controllers;

use Illuminate\Http\Response;
use Afaqy\Core\Http\Controllers\Controller;

class WashingStationRerportController extends Controller
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
                'prop' => 'unit_code',
                'name' => 'كود المركبة',
                'unit' => null,
            ],
            [
                'prop' => 'plate_number',
                'name' => 'رقم اللوحة',
                'unit' => null,
            ],
            [
                'prop' => 'contractor',
                'name' => 'المقاول',
                'unit' => null,
            ],
            [
                'prop' => 'contract',
                'name' => 'رقم العقد',
                'unit' => null,
            ],
            [
                'prop' => 'unit_type',
                'name' => 'نوع المركبة',
                'unit' => null,
            ],
            [
                'prop' => 'checkin_time',
                'name' => 'وقت الدخول',
                'unit' => 'ton',
            ],
            [
                'prop' => 'checkout_time',
                'name' => 'وقت الخروج',
                'unit' => 'ton',
            ],
            [
                'prop' => 'total_units',
                'name' => 'إجمالي عدد المركبات',
                'unit' => 'ton',
            ],
        ];

        return $this->returnSuccess('', $headers);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function report()
    {
        return $this->returnSuccess('', []);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function excelExport()
    {
        return $this->returnSuccess('', []);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function pdfExport()
    {
        return $this->returnSuccess('', []);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function totalWeight()
    {
        return $this->returnSuccess('', [
            'total_weight' => 0,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function chart()
    {
        return $this->returnSuccess('', []);
    }
}
