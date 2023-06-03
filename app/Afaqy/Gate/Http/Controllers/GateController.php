<?php

namespace Afaqy\Gate\Http\Controllers;

use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Gate\Http\Reports\GateListReport;
use Afaqy\Gate\Http\Reports\GateExcelReport;
use Afaqy\Gate\Http\Requests\GateIndexRequest;
use Afaqy\Gate\Http\Requests\GateExportRequest;

class GateController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/gates",
     *  tags={"Gates"},
     *  summary="Get list of the gates.",
     *  description="",
     *  operationId="GatesList",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name, serial, direction."
     *  ),
     *  @SWG\Parameter(
     *      name="per_page", type="integer", in="query", description="The number of items per page. min 10 and max 200. default 50.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by name, serial or direction.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          {
     *              "id"="1",
     *              "name"="بوابه 55",
     *              "serial"="213234445",
     *              "direction"="دخول",
     *          },
     *          {
     *              "id"="1",
     *              "name"="بوابه 65",
     *              "serial"="345654454",
     *              "direction"="خروج",
     *          },
     *      }),
     *      @SWG\Property(property="meta", type="string", example={
     *          {
     *              "pagination"={
     *                  "currentPage": 1,
     *                  "firstPage": 1,
     *                  "lastPage": 2,
     *                  "perPage": 10,
     *                  "count": 10,
     *                  "totalRecords": 20,
     *                  "links": {
     *                      "first": "https://dev.api.mardam.afaqy.co/api/v1/gates?page=1",
     *                      "last": "https://dev.api.mardam.afaqy.co/api/v1/gates?page=2",
     *                      "previous": null,
     *                      "next": "https://dev.api.mardam.afaqy.co/api/v1/gates?page=2"
     *                  }
     *          }
     *          },
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
    public function index(GateIndexRequest $request)
    {
        return (new GateListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/gates/export",
     *  tags={"Gates"},
     *  summary="Export Gates.",
     *  description="",
     *  operationId="export",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="search in name, serial, direction.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful download Excel sheet."),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=422, description="Unprocessable Entity", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="The given data was invalid."),
     *      @SWG\Property(property="errors", type="string", example={
     *          "per_page"={"The per page must be at least 10."},
     *          "keyword"={"The keyword must be string."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function export(GateExportRequest $request)
    {
        return (new GateExcelReport($request))->show();
    }
}
