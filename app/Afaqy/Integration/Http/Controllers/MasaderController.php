<?php

namespace Afaqy\Integration\Http\Controllers;

use Illuminate\Http\Response;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Integration\Http\Requests\MasaderRequest;
use Afaqy\Integration\Http\Reports\MasaderTransactionsReport;

class MasaderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function transactions(MasaderRequest $request)
    {
        return (new MasaderTransactionsReport($request))->show();
    }
}
