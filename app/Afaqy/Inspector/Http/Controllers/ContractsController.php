<?php

namespace Afaqy\Inspector\Http\Controllers;

use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Inspector\Http\Reports\Supervisor\ActiveContractListReport;

class ContractsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function activeList()
    {
        return (new ActiveContractListReport)->show();
    }
}
