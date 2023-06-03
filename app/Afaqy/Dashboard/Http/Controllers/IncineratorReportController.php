<?php

namespace Afaqy\Dashboard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Afaqy\Core\Http\Controllers\Controller;

class IncineratorReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function header(): JsonResponse
    {
        // we return table header static, because of front-end component.
        // You can remove this method anytime if no longer need it.

        $headers = [
            [
                'prop' => 'unit_code',
                'name' => 'رمز الوحده',
                'unit' => null,
            ],
            [
                'prop' => 'plate_number',
                'name' => 'رقم اللوحه',
                'unit' => null,
            ],
            [
                'prop' => 'waste_type_name',
                'name' => 'أسم نوع القمامه',
                'unit' => null,
            ],
            [
                'prop' => 'waste_weight',
                'name' => 'وزن القمامه',
                'unit' => null,
            ],
            [
                'prop' => 'check_in_time',
                'name' => 'وقت الدخول',
                'unit' => null,
            ],
            [
                'prop' => 'check_out_time',
                'name' => 'وقت الخروج',
                'unit' => null,
            ],
        ];

        return $this->returnSuccess('', $headers);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function report(): JsonResponse
    {
        return $this->returnSuccess('', []);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function excelExport(): JsonResponse
    {
        return $this->returnSuccess('', []);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function pdfExport(): JsonResponse
    {
        return $this->returnSuccess('', []);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function totalWeight(): JsonResponse
    {
        return $this->returnSuccess('', [
            'total_weight' => 0,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function chart(): JsonResponse
    {
        return $this->returnSuccess('', []);
    }
}
