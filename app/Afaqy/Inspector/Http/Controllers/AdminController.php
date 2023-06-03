<?php

namespace Afaqy\Inspector\Http\Controllers;

use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Inspector\Http\Requests\IndexTicketRequest;
use Afaqy\Inspector\Http\Reports\Admin\AdminTicketListReport;

class AdminController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/mob/admin/tickets",
     *  tags={"TIckets"},
     *  summary="list inspector tickets by status.",
     *  description="",
     *  operationId="inspector-tickets-list",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="status", type="string", in="query", description="To get list of tickets for the given status.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 42,
     *          "contracto_name": "Mohamed osama",
     *          "contracto_name": "Mohamed osama",
     *          "neighborhood": "Al.Riyad",
     *      })
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function listTickets(IndexTicketRequest $request)
    {
        return (new AdminTicketListReport($request))->show();
    }
}
