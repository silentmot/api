<?php

namespace Afaqy\Dashboard\Http\Controllers;

use Illuminate\Http\Response;
use Afaqy\Core\Http\Controllers\Controller;

class WaterPurificationRerportController extends Controller
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
                'prop' => 'decayed_liquids',
                'name' => 'الرشيح',
                'unit' => 'meter',
            ],
            [
                'prop' => 'conformed_liquids',
                'name' => 'السوائل المطابقة',
                'unit' => 'meter',
            ],
            [
                'prop' => 'non_conformed_liquids',
                'name' => 'السوائل غير المطابقة',
                'unit' => 'meter',
            ],
            [
                'prop' => 'total_weight',
                'name' => 'إجمالي وزن السوائل بالمتر المكعب',
                'unit' => 'meter',
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
