<?php

namespace Afaqy\Activity\Http\Controllers;

use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Activity\Http\Requests\ActivityRequest;
use Afaqy\Activity\Http\Reports\ActivityListReport;
use Afaqy\Activity\Http\Reports\ActivityShowReport;

class ActivityController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/mob/admin/activities",
     *  tags={"Activitiy"},
     *  summary="list user activities.",
     *  description="",
     *  operationId="activities-list",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "record_id": 42,
     *          "username": "owner",
     *          "module_name": "Contract",
     *          "action_name": "created",
     *          "created_at": "2021-01-14T09:11:54.000000Z",
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
    public function index(ActivityRequest $request)
    {
        return (new ActivityListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/mob/activiries/{id}",
     *  tags={"Activity"},
     *  summary="get activity by id.",
     *  description="",
     *  operationId="activities-show",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "record_id": 42,
     *          "username": "owner",
     *          "module_name": "Contract",
     *          "action_name": "created",
     *          "created_at": "2021-01-14T09:11:54.000000Z",
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
    public function show($id)
    {
        return (new ActivityShowReport($id))->show();
    }
}
