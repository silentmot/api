<?php

namespace Afaqy\District\Http\Controllers;

use Illuminate\Http\Response;
use Afaqy\District\DTO\DistrictData;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\District\Actions\StoreDistrictAction;
use Afaqy\District\Actions\UpdateDistrictAction;
use Afaqy\District\Actions\DeleteDistrictsAction;
use Afaqy\District\Http\Reports\DistrictPdfReport;
use Afaqy\District\Http\Reports\DistrictListReport;
use Afaqy\District\Http\Reports\DistrictShowReport;
use Afaqy\District\Http\Reports\DistrictExcelReport;
use Afaqy\District\Http\Requests\DistrictIndexRequest;
use Afaqy\District\Http\Requests\DistrictStoreRequest;
use Afaqy\District\Http\Requests\DistrictDeleteRequest;
use Afaqy\District\Http\Requests\DistrictUpdateRequest;
use Afaqy\District\Http\Reports\ContractsListForDistrictReport;
use Afaqy\District\Http\Reports\DistrictNeighborhoodsListReport;

class DistrictController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/districts",
     *  tags={"Districts"},
     *  summary="Clean City Districts.",
     *  description="",
     *  operationId="list",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in district name.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="active", type="boolean", in="query", description="To filter in district status.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="per_page", type="integer", in="query", description="The number of items per page. min 10 and max 200. default 50.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To set sorting columns(id, name, neighborhoods_count, sub_neighborhoods_count, units_count)", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 16,
     *          "name": "المليساء",
     *          "neighborhoods_count": 2,
     *          "subNeighborhoods_count": 3,
     *          "units_count": 10
     *      }),
     *      @SWG\Property(property="meta", type="string", example={
     *          "currentPage": 1,
     *          "firstPage": 1,
     *          "lastPage": 1,
     *          "perPage": 15,
     *          "count": 2,
     *          "totalRecords": 2,
     *          "links": {
     *              "first": "https://dev.api.mardam.afaqy.co/api/v1/roles?page=1",
     *              "last": "https://dev.api.mardam.afaqy.co/api/v1/roles?page=1",
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
    public function index(DistrictIndexRequest $request)
    {
        return (new DistrictListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/districts/export/excel",
     *  tags={"Districts"},
     *  summary="Export Districts as Excel file.",
     *  description="",
     *  operationId="export-district-excel",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in district name.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="active", type="boolean", in="query", description="To filter in district status.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To set sorting columns(id, name, neighborhoods_count, sub_neighborhoods_count, units_count)", required=false
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
    public function exportExcel(DistrictIndexRequest $request)
    {
        return (new DistrictExcelReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/districts/export/pdf",
     *  tags={"Districts"},
     *  summary="Export Districts as PDF file.",
     *  description="",
     *  operationId="export-district-pdf",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in district name.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="active", type="boolean", in="query", description="To filter in district status.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To set sorting columns(id, name, neighborhoods_count, sub_neighborhoods_count, units_count)", required=false
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
    public function exportPdf(DistrictIndexRequest $request)
    {
        return (new DistrictPdfReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/districts/:id/uncontracted-neighborhoods",
     *  tags={"Districts"},
     *  summary="Un-contracted neighborhoods for given district.",
     *  description="",
     *  operationId="uncontracted-neighborhoods-list",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="To filter un-contracted neighborhoods for given district.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 42,
     *          "name": "حي الرويس"
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
    public function districtNeighborhoods(int $id)
    {
        return (new DistrictNeighborhoodsListReport($id))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/districts/:id",
     *  tags={"Districts"},
     *  summary="Show district details.",
     *  description="",
     *  operationId="show-district",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for district.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *              "name": "bla",
     *              "neighborhoods": {
     *                  {
     *                      "id": 1,
     *                      "name": "bla",
     *                      "population": 3123123,
     *                      "status": true,
     *                      "sub_neighborhoods": {
     *                          "bla",
     *                          "bla"
     *                      }
     *                  }
     *              }
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
    public function show(int $id)
    {
        return (new DistrictShowReport($id))->show();
    }

    /**
     * @SWG\Post(
     *  path="/v1/districts/",
     *  tags={"Districts"},
     *  summary="Store district.",
     *  description="",
     *  operationId="district-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="name", type="string", example="الشرفية"),
     *         @SWG\Property(
     *             property="neighborhoods",
     *             type="array",
     *             @SWG\items(type="object",
     *                 @SWG\Property(property="name", type="string", example="الأمواج"),
     *                 @SWG\Property(property="population", type="string", example="2312"),
     *                 @SWG\Property(property="status", type="boolean", example="true"),
     *                 @SWG\Property(
     *                   property="sub_neighborhoods",
     *                   type="array",
     *                   @SWG\items(type="string", example="الثاني"),
     *               ),
     *             ),
     *         ),
     *     )
     *   ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ الحى بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 17
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="13001"),
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
     *  @SWG\Response(response=422, description="Unprocessable Entity", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="The given data was invalid."),
     *      @SWG\Property(property="errors", type="string", example={
     *          "name"={"The name must be string."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(DistrictStoreRequest $request)
    {
        $dto = DistrictData::fromRequest($request);

        $result = (new StoreDistrictAction($dto))->execute();

        $messages = [
            'success' => 'district::district.store-success',
            'fail'    => 'district::district.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            13001
        );
    }

    /**
     * @SWG\Put(
     *  path="/v1/districts/:id",
     *  tags={"Districts"},
     *  summary="Update district.",
     *  description="",
     *  operationId="district-update",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for district.", required=true
     *  ),
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="name", type="string", example="الشرفية"),
     *         @SWG\Property(
     *             property="neighborhoods",
     *             type="array",
     *             @SWG\items(type="object",
     *                 @SWG\Property(property="id", type="integer", example="1"),
     *                 @SWG\Property(property="name", type="string", example="الأمواج"),
     *                 @SWG\Property(property="population", type="string", example="2312"),
     *                 @SWG\Property(property="status", type="boolean", example="true"),
     *                 @SWG\Property(
     *                   property="sub_neighborhoods",
     *                   type="array",
     *                   @SWG\items(type="string", example="الثاني"),
     *               ),
     *             ),
     *         ),
     *     )
     *   ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تحديث الحى بنجاح"),
     *      @SWG\Property(property="data", type="string", example={})
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="13002"),
     *      @SWG\Property(property="message", type="string", example="حديث خطأ أثناء التحديث, ربجاء المحاولة مرة اخري."),
     *      @SWG\Property(property="errors", type="string", example={})
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
     *          "name"={"The name must be string."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function update(DistrictUpdateRequest $request, int $id)
    {
        $dto = DistrictData::fromRequest($request, $id);

        $result = (new UpdateDistrictAction($dto))->execute();

        $messages = [
            'success' => 'district::district.update-success',
            'fail'    => 'district::district.update-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            13002
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/districts/:id",
     *  tags={"Districts"},
     *  summary="Delete district in Clean City system.",
     *  description="",
     *  operationId="district-delete",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for district.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف المنطقة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="13003"),
     *      @SWG\Property(property="message", type="string", example="حدث خطأ أثناء الحذف, برجاء التأكد ان المنطقة غير مرتبظ بأي عقود و المحاولة مرة أخري."),
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
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroy(int $id)
    {
        $result = (new DeleteDistrictsAction($id))->execute();

        $messages = [
            'success' => 'district::district.delete-success',
            'fail'    => 'district::district.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            13003
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/districts/",
     *  tags={"Districts"},
     *  summary="Delete many districts in Clean City system.",
     *  description="",
     *  operationId="districts-delete-many",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="ids[]", type="array", collectionFormat="multi", in="formData", @SWG\Items(type="integer"), description="districts ids.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف المناطق بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="13003"),
     *      @SWG\Property(property="message", type="string", example="حدث خطأ أثناء الحذف, برجاء التأكد ان المنطقة غير مرتبظ بأي عقود و المحاولة مرة أخري."),
     *      @SWG\Property(property="errors", type="string", example={})
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
     *          "ids"={"المنطقة غير متواجدة."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroyMany(DistrictDeleteRequest $request)
    {
        $ids = $request->input('ids');

        $result = (new DeleteDistrictsAction($ids))->execute();

        $messages = [
            'success' => 'district::district.delete-success',
            'fail'    => 'district::district.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            13003
        );
    }

    /**
     * @SWG\Get(
     *  path="/v1/districts/:id/contracts",
     *  tags={"Districts"},
     *  summary="contracts for the given district.",
     *  description="",
     *  operationId="district-contracts-list",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="To get contracts for the given district.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 42,
     *          "name": "عقد 1"
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
    public function contracts(int $id)
    {
        return (new ContractsListForDistrictReport($id))->show();
    }
}
