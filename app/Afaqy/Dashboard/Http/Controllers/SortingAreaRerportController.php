<?php

namespace Afaqy\Dashboard\Http\Controllers;

use Illuminate\Http\Response;
use Afaqy\Core\Http\Controllers\Controller;

class SortingAreaRerportController extends Controller
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
                'prop' => 'checkin_weight',
                'name' => 'دخل مصنع الفرز',
                'unit' => 'ton',
            ],
            [
                'prop' => 'checkout_weight',
                'name' => 'خرج مصنع الفرز',
                'unit' => 'ton',
            ],
            [
                'prop' => 'rejected_waste',
                'name' => 'النفايات المرفوضة',
                'unit' => 'ton',
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
