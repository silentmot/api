<?php

namespace Afaqy\Permission\Http\Controllers;

use Afaqy\Permission\DTO\UnitData;
use Afaqy\Permission\DTO\AppendUnitsData;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Permission\Lookups\PermissionTypeLookup;
use Afaqy\Permission\Models\SortingAreaPermission;
use Afaqy\Permission\Http\Reports\PermissionPdfReport;
use Afaqy\Permission\Models\DamagedProjectsPermission;
use Afaqy\Permission\Http\Reports\PermissionListReport;
use Afaqy\Permission\Actions\DeletePermissionUnitAction;
use Afaqy\Permission\Actions\UpdatePermissionUnitAction;
use Afaqy\Permission\Http\Reports\PermissionExcelReport;
use Afaqy\Permission\Models\CommercialDamagedPermission;
use Afaqy\Permission\Models\IndividualDamagedPermission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Afaqy\Permission\Http\Reports\PermissionLogListReport;
use Afaqy\Permission\Http\Reports\PermissionSerialsReport;
use Afaqy\Permission\Http\Requests\PermissionIndexRequest;
use Afaqy\Permission\Models\GovernmentalDamagedPermission;
use Afaqy\Permission\Http\Requests\PermissionExportRequest;
use Afaqy\Permission\Http\Requests\UpdatePermissionUnitRequest;
use Afaqy\Permission\Http\Requests\PermissionAppendUnitsRequest;
use Afaqy\Permission\Http\Reports\Projects\ProjectsPermissionShowReport;
use Afaqy\Permission\Actions\Aggregators\AppendUnitsPermissionAggregator;
use Afaqy\Permission\Http\Reports\Sorting\SortingAreaPermissionShowReport;
use Afaqy\Permission\Http\Reports\Commercial\CommercialPermissionShowReport;
use Afaqy\Permission\Http\Reports\Individual\IndividualPermissionShowReport;
use Afaqy\Permission\Http\Reports\Governmental\GovernmentalPermissionShowReport;

class PermissionController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/permissions",
     *  tags={"Permissions"},
     *  summary="Clean City Permissions.",
     *  description="",
     *  operationId="permissions-list",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in district name.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="per_page", type="integer", in="query", description="The number of items per page. min 10 and max 200. default 50.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To set sorting columns(permission_number, type, allowed_weight, actual_weight)", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 16,
     *          "permission_number": 723203224,
     *          "permission_type": "commercial",
     *          "type": "امر اتلاف تجاري",
     *          "allowed_weight": 1234,
     *          "actual_weight": 0,
     *      }),
     *      @SWG\Property(property="meta", type="string", example={
     *          "currentPage": 1,
     *          "firstPage": 1,
     *          "lastPage": 1,
     *          "perPage": 15,
     *          "count": 2,
     *          "totalRecords": 2,
     *          "links": {
     *              "first": "https://dev.api.mardam.afaqy.co/api/v1/permissions?page=1",
     *              "last": "https://dev.api.mardam.afaqy.co/api/v1/permissions?page=1",
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
    public function index(PermissionIndexRequest $request)
    {
        return (new PermissionListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/permissions/logs",
     *  tags={"Permissions"},
     *  summary="Clean City Permissions.",
     *  description="",
     *  operationId="permissions-list-logs",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in district name.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="per_page", type="integer", in="query", description="The number of items per page. min 10 and max 200. default 50.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To set sorting columns(permission_number, type, allowed_weight, actual_weight)", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 16,
     *          "permission_number": 723203224,
     *          "permission_type": "commercial",
     *          "type": "امر اتلاف تجاري",
     *          "allowed_weight": 1234,
     *          "actual_weight": 0,
     *      }),
     *      @SWG\Property(property="meta", type="string", example={
     *          "currentPage": 1,
     *          "firstPage": 1,
     *          "lastPage": 1,
     *          "perPage": 15,
     *          "count": 2,
     *          "totalRecords": 2,
     *          "links": {
     *              "first": "https://dev.api.mardam.afaqy.co/api/v1/permissions?page=1",
     *              "last": "https://dev.api.mardam.afaqy.co/api/v1/permissions?page=1",
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
    public function logs(PermissionIndexRequest $request)
    {
        return (new PermissionLogListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/permissions/export/excel",
     *  tags={"Permissions"},
     *  summary="Export Permissions.",
     *  description="",
     *  operationId="permissions-list-export",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To set sorting columns(permission_number, type, allowed_weight, actual_weight)", required=false
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
    public function exportExcel(PermissionExportRequest $request)
    {
        return (new PermissionExcelReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/permissions/export/pdf",
     *  tags={"Permissions"},
     *  summary="Export Permissions ad PDF file.",
     *  description="",
     *  operationId="permissions-list-export-pdf",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To set sorting columns(permission_number, type, allowed_weight, actual_weight)", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
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
    public function exportPdf(PermissionExportRequest $request)
    {
        return (new PermissionPdfReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/permissions/types",
     *  tags={"Permissions"},
     *  summary="Clean City Permissions Types.",
     *  description="",
     *  operationId="permissions-types",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "دمارات أفراد",
     *          "دمارات مشاريع",
     *          "امر اتلاف تجارى",
     *          "امر اتلاف حكومى"
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
    public function types()
    {
        $types = array_values(PermissionTypeLookup::except(['sorting']));

        return $this->returnSuccess('', $types);
    }

    /**
     * @SWG\Get(
     *  path="/v1/permissions/individual/{id}",
     *  tags={"Permissions"},
     *  summary="Show permission details.",
     *  description="",
     *  operationId="show-individual-permission",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for permission.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *                  "id": 1,
     *                 "demolition_serial": "78452678",
     *                 "permission_number": "2463",
     *                 "permission_date": "21-02-1972",
     *                 "district_id": "1",
     *                 "neighborhood_id": "17",
     *                 "owner_name": "Elmo Ward",
     *                 "owner_phone": "391616",
     *                 "street": "992 Rosalind Heights Apt. 427",
     *                 "national_id": 2609171094,
     *                  "units":{
     *                  {
     *                      "id": 13,
     *                      "plate_number": "wrz 377",
     *                      "weight": "",
     *                      "checkin_time": "",
     *                  },
     *                  {
     *                      "id": 14,
     *                      "plate_number": "hjg 897",
     *                      "weight": "",
     *                      "checkin_time": "",
     *                  }
     *                },
     *           "total_weight": 0,
     *      })
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=404, description="Not Found", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Document or file requested by the client was not found."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */

    /**
     * @SWG\Get(
     *  path="/v1/permissions/commercial/{id}",
     *  tags={"Permissions"},
     *  summary="Show permission details.",
     *  description="",
     *  operationId="show-commercial-permission",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for permission.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *                  "id": 1,
     *                 "permission_number": "72320",
     *                 "permission_date": "20-01-2019",
     *                 "company_name": "Beer, Nolan and Waters",
     *                 "representative_name": "Ahmed",
     *                 "company_commercial_number": "1987654332",
     *                 "national_id": 1987654332,
     *                 "allowed_weight": 1234,
     *                  "units":{
     *                  {
     *                      "id": 13,
     *                      "plate_number": "wrz 377",
     *                      "weight": "",
     *                      "checkin_time": "",
     *                  }
     *                },
     *                "total_weight": 0,
     *      })
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=404, description="Not Found", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Document or file requested by the client was not found."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */

    /**
     * @SWG\Get(
     *  path="/v1/permissions/project/{id}",
     *  tags={"Permissions"},
     *  summary="Show permission details.",
     *  description="",
     *  operationId="show-project-permission",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for permission.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *                  "id": 1,
     *                 "demolition_serial": "78452678",
     *                 "permission_number": "2463",
     *                 "permission_date": "21-02-1972",
     *                 "company_name": "Beer, Nolan and Waters",
     *                 "company_commercial_number": 4888012397,
     *                  "units":{
     *                  {
     *                      "id": 13,
     *                      "plate_number": "wrz 377",
     *                      "weight": "",
     *                      "checkin_time": "",
     *                 },
     *                 {
     *                      "id": 14,
     *                      "plate_number": "qwq 377",
     *                      "weight": "",
     *                      "checkin_time": "",
     *                 },
     *                },
     *                "total_weight": 0,
     *      })
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=404, description="Not Found", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Document or file requested by the client was not found."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */

    /**
     * @SWG\Get(
     *  path="/v1/permissions/governmental/{id}",
     *  tags={"Permissions"},
     *  summary="Show permission details.",
     *  description="",
     *  operationId="show-governmental-permission",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for permission.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *                  "id": 1,
     *                 "permission_number": "2463",
     *                 "permission_date": "21-02-1972",
     *                 "entity_name": "Beer, Nolan and Waters",
     *                 "company_commercial_number": 4888012397,
     *                 "representative_name": "Bailee Kassulke PhD",
     *                 "national_id": 9476844091,
     *                 "allowed_weight": 6925,
     *                  "units":{
     *                  {
     *                      "id": 13,
     *                      "plate_number": "wrz 377",
     *                      "weight": "",
     *                      "checkin_time": "",
     *                 },
     *                 {
     *                      "id": 14,
     *                      "plate_number": "qwq 377",
     *                      "weight": "",
     *                      "checkin_time": "",
     *                 },
     *                },
     *                "total_weight": 0,
     *      })
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=404, description="Not Found", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Document or file requested by the client was not found."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */

    /**
     * @SWG\Get(
     *  path="/v1/permissions/sorting/{id}",
     *  tags={"Permissions"},
     *  summary="Show permission details.",
     *  description="",
     *  operationId="show-sorting-area-permission",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for permission.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *                  "id": 1,
     *                 "permission_number": "2463",
     *                 "entity_name": "Beer, Nolan and Waters",
     *                 "representative_name": "Bailee Kassulke PhD",
     *                 "waste_type_name": "Bailee Kassulke PhD",
     *                 "national_id": 9476844091,
     *                 "allowed_weight": 6925,
     *                  "units":{
     *                  {
     *                      "id": 13,
     *                      "plate_number": "wrz 377",
     *                      "weight": "",
     *                      "checkin_time": "",
     *                 },
     *                 {
     *                      "id": 14,
     *                      "plate_number": "qwq 377",
     *                      "weight": "",
     *                      "checkin_time": "",
     *                 },
     *                },
     *                "total_weight": 0,
     *      })
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=404, description="Not Found", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Document or file requested by the client was not found."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function showPermission($type, $id)
    {
        $report = [
            'commercial'   => CommercialPermissionShowReport::class,
            'governmental' => GovernmentalPermissionShowReport::class,
            'individual'   => IndividualPermissionShowReport::class,
            'project'      => ProjectsPermissionShowReport::class,
            'sorting'      => SortingAreaPermissionShowReport::class,
        ];

        return (new $report[$type]($id))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/permissions/{type}/serials",
     *  tags={"Permissions"},
     *  summary="Show permission serials.",
     *  description="",
     *  operationId="show-permission-serials",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="type", type="string", in="query", description="permission type select from [individual, project, commercial, governmental].", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          {
     *              "serial": "23423423"
     *          },
     *          {
     *              "serial": "34324"
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
     *  @SWG\Response(response=404, description="Not Found", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Document or file requested by the client was not found."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function permissionSerials($type)
    {
        $model = [
            'individual'   => IndividualDamagedPermission::class,
            'project'      => DamagedProjectsPermission::class,
            'commercial'   => CommercialDamagedPermission::class,
            'governmental' => GovernmentalDamagedPermission::class,
        ];

        if (!isset($model[$type])) {
            throw new ModelNotFoundException;
        }

        return (new PermissionSerialsReport($model[$type]))->show();
    }

    /**
     * @SWG\Post(
     *  path="/v1/permissions/:type/append-units/:number",
     *  tags={"Permissions"},
     *  summary="Append unit to given permission type.",
     *  description="",
     *  operationId="append-units-permission",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="type", type="string", in="query", description="permission type select from [individual, project, commercial, governmental].", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="number", type="string", in="query", description="id/permission-number for the given permission.", required=true
     *  ),
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="units",
     *             type="array",
     *             @SWG\items(type="object",
     *                 @SWG\Property(property="plate_number", type="string", example="bmw1234"),
     *             ),
     *             @SWG\items(type="object",
     *                 @SWG\Property(property="plate_number", type="string", example="bmw1784"),
     *             ),
     *             @SWG\items(type="object",
     *                 @SWG\Property(property="plate_number", type="string", example="bmw987"),
     *             ),
     *         ),
     *     )
     *   ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تحديث التصريح بنجاح."),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 17
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="5001"),
     *      @SWG\Property(property="message", type="string", example="حديث خطأ أثناء الحفظ, ربجاء المحاولة مرة اخري."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=404, description="Not Found", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Document or file requested by the client was not found."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=422, description="Unprocessable Entity", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="The given data was invalid."),
     *      @SWG\Property(property="errors", type="string", example={
     *          "name"={"The name must be string."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function appendUnits(PermissionAppendUnitsRequest $request, $type, $number)
    {
        $model = [
            'individual'   => IndividualDamagedPermission::class,
            'project'      => DamagedProjectsPermission::class,
            'commercial'   => CommercialDamagedPermission::class,
            'governmental' => GovernmentalDamagedPermission::class,
        ];

        if (!isset($model[$type])) {
            throw new ModelNotFoundException;
        }

        $dto = AppendUnitsData::fromRequest($request, $model[$type], $number);

        $result = (new AppendUnitsPermissionAggregator($dto))->execute();

        $messages = [
            'success' => 'permission::permission.update-success',
            'fail'    => 'permission::permission.update-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            5001
        );
    }

    /**
     * This method hasn't any direct API to FrontEnd, we only use it in integration with CAP.
     */
    public function updatePermissionUnit(UpdatePermissionUnitRequest $request, $type, $qr_code)
    {
        $dto = UnitData::fromRequest($request);

        $result = (new UpdatePermissionUnitAction($dto, $qr_code))->execute();

        $messages = [
            'success' => 'permission::permission.update-unit-success',
            'fail'    => 'permission::permission.update-unit-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            8200
        );
    }

    /**
     * This method hasn't any direct API to FrontEnd, we only use it in integration with CAP.
     */
    public function deletePermissionUnit($type, $qr_code)
    {
        $model = [
            'individual'   => IndividualDamagedPermission::class,
            'project'      => DamagedProjectsPermission::class,
            'commercial'   => CommercialDamagedPermission::class,
            'governmental' => GovernmentalDamagedPermission::class,
            'sorting'      => SortingAreaPermission::class,
        ];

        if (!isset($model[$type])) {
            throw new ModelNotFoundException;
        }

        $result = (new DeletePermissionUnitAction($model[$type], $qr_code))->execute();

        $messages = [
            'success' => 'permission::permission.delete-unit-success',
            'fail'    => 'permission::permission.delete-unit-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            8300
        );
    }
}
