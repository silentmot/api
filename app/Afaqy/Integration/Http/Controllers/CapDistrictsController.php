<?php

namespace Afaqy\Integration\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Integration\Http\Reports\CapDistrictListReport;

class CapDistrictsController extends Controller
{
    public function __construct()
    {
        App::setLocale('en');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return (new CapDistrictListReport)->show();
    }
}
