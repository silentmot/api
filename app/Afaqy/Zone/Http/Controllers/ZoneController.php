<?php

namespace Afaqy\Zone\Http\Controllers;

use Illuminate\Http\Response;
use Afaqy\Zone\Http\Reports\ZonePdfReport;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Zone\Http\Reports\ZoneListReport;
use Afaqy\Zone\Http\Reports\ZoneExcelReport;
use Afaqy\Zone\Http\Requests\ZoneIndexRequest;

class ZoneController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/zones",
     *  tags={"Zones"},
     *  summary="Clean City system zones.",
     *  description="",
     *  operationId="listZones",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in zones names.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="per_page", type="integer", in="query", description="The number of items per page. min 10 and max 200. default 50.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (id, name)", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 10,
     *          "name": "Vero id minima.",
     *          "devices_names": {
     *              "bla",
     *              "bla"
     *          },
     *          "gates_names": {
     *              "quos"
     *          },
     *          "scale_name": "expedita"
     *      }),
     *      @SWG\Property(property="meta", type="string", example={
     *          "currentPage": 1,
     *          "firstPage": 1,
     *          "lastPage": 1,
     *          "perPage": 15,
     *          "count": 2,
     *          "totalRecords": 2,
     *          "links": {
     *              "first": "https://dev.api.mardam.afaqy.co/api/v1/zones?page=1",
     *              "last": "https://dev.api.mardam.afaqy.co/api/v1/zones?page=1",
     *              "previous": null,
     *              "next": null
     *          }
     *      })
     *  )),
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
    public function index(ZoneIndexRequest $request)
    {
        return (new ZoneListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/zones/export/excel",
     *  tags={"Zones"},
     *  summary="Export Clean City zones as Excel file.",
     *  description="",
     *  operationId="exportZones-excel",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in zones names.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (id, name)", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="Successful download Excel sheet."),
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
     *          "sort"={"The sort key invalid."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function exportExcel(ZoneIndexRequest $request)
    {
        return (new ZoneExcelReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/zones/export/pdf",
     *  tags={"Zones"},
     *  summary="Export Clean City zones as PDF file.",
     *  description="",
     *  operationId="exportZones-pdf",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in zones names.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (id, name)", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="output", type="string", in="query", description="send it equal raw to return raw data", required=false
     *  ),
     *  @SWG\Response(response=200, description="Successful download PDF file."),
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
     *          "sort"={"The sort key invalid."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function exportPdf(ZoneIndexRequest $request)
    {
        return (new ZonePdfReport($request))->show();
    }
}
