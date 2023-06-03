<?php

namespace Afaqy\WasteType\Http\Controllers;

use Afaqy\WasteType\DTO\WasteTypeData;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\WasteType\Actions\StoreWasteTypeAction;
use Afaqy\WasteType\Actions\UpdateWasteTypeAction;
use Afaqy\WasteType\Actions\DeleteWasteTypesAction;
use Afaqy\WasteType\Http\Reports\WasteTypePdfReport;
use Afaqy\WasteType\Http\Reports\WasteTypeListReport;
use Afaqy\WasteType\Http\Reports\WasteTypeShowReport;
use Afaqy\WasteType\Http\Reports\WasteTypeExcelReport;
use Afaqy\WasteType\Http\Requests\WasteTypeIndexRequest;
use Afaqy\WasteType\Http\Requests\WasteTypeStoreRequest;
use Afaqy\WasteType\Http\Requests\WasteTypeDeleteRequest;
use Afaqy\WasteType\Http\Requests\WasteTypeUpdateRequest;

class WasteTypeController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/waste-types",
     *  tags={"WasteTypes"},
     *  summary="Clean City system waste types.",
     *  description="",
     *  operationId="Waste-type-list",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in waste types names.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="per_page", type="integer", in="query", description="The number of items per page. min 10 and max 200. default 50.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To set sorting columns, select from (id, name, units_count)", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *             "id": 10,
     *             "name": "Non cupiditate",
     *             "units_count": 5
     *      }),
     *      @SWG\Property(property="meta", type="string", example={
     *          "currentPage": 1,
     *          "firstPage": 1,
     *          "lastPage": 1,
     *          "perPage": 15,
     *          "count": 2,
     *          "totalRecords": 2,
     *          "links": {
     *              "first": "https://dev.api.mardam.afaqy.co/api/v1/waste-types?page=1",
     *              "last": "https://dev.api.mardam.afaqy.co/api/v1/waste-types?page=1",
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
    public function index(WasteTypeIndexRequest $request)
    {
        return (new WasteTypeListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/waste-types/export/excel",
     *  tags={"WasteTypes"},
     *  summary="Export Clean City waste types.",
     *  description="",
     *  operationId="Waste-type-export-excel",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in waste types names.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To set sorting columns, select from (id, name, units_count)", required=false
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
    public function exportExcel(WasteTypeIndexRequest $request)
    {
        return (new WasteTypeExcelReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/waste-types/export/pdf",
     *  tags={"WasteTypes"},
     *  summary="Export Clean City waste types ad PDF file.",
     *  description="",
     *  operationId="Waste-type-export-pdf",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in waste types names.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To set sorting columns, select from (id, name, units_count)", required=false
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
    public function exportPdf(WasteTypeIndexRequest $request)
    {
        return (new WasteTypePdfReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/waste-types/:id",
     *  tags={"WasteTypes"},
     *  summary="show waste type information for the given id.",
     *  description="",
     *  operationId="Waste-type-show",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for waste type.", required=true
     *  ),
     *  @SWG\Response(response=200, description="Successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *             "id": 10,
     *             "name": "نفايات منزلية"
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
        return (new WasteTypeShowReport($id))->show();
    }

    /**
     * @SWG\Post(
     *  path="/v1/waste-types/",
     *  tags={"WasteTypes"},
     *  summary="Store waste type in Clean City system.",
     *  description="",
     *  operationId="Waste-type-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="name", type="string", in="formData", description="waste type name.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ نوع القمامة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 17
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="2003"),
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
    public function store(WasteTypeStoreRequest $request)
    {
        $dto = WasteTypeData::fromRequest($request);

        $result = (new StoreWasteTypeAction($dto))->execute();

        $messages = [
            'success' => 'wastetype::wasteType.store-success',
            'fail'    => 'wastetype::wasteType.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            2003
        );
    }

    /**
     * @SWG\Put(
     *  path="/v1/waste-types/:id",
     *  tags={"WasteTypes"},
     *  summary="Update waste type in Clean City system.",
     *  description="",
     *  operationId="Waste-type-update",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="waste type id.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="name", type="string", in="formData", description="waste type name.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تحديث نوع القمامة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="2004"),
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
    public function update(WasteTypeUpdateRequest $request, $id)
    {
        $dto = WasteTypeData::fromRequest($request, $id);

        $result = (new UpdateWasteTypeAction($dto))->execute();

        $messages = [
            'success' => 'wastetype::wasteType.update-success',
            'fail'    => 'wastetype::wasteType.update-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            2004
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/waste-types/:id",
     *  tags={"WasteTypes"},
     *  summary="Delete waste type in Clean City system.",
     *  description="",
     *  operationId="Waste-type-delete",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for waste type.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف نوع القمامة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="2005"),
     *      @SWG\Property(property="message", type="string", example="حدث خطأ أثناء الحذف, برجاء التأكد ان نوع القمامة غير مرتبظ بأي مركبات و المحاولة مرة أخري."),
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
        $result = (new DeleteWasteTypesAction($id))->execute();

        $messages = [
            'success' => 'wastetype::wasteType.delete-success',
            'fail'    => 'wastetype::wasteType.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            2005
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/waste-types/",
     *  tags={"WasteTypes"},
     *  summary="Delete many waste types in Clean City system.",
     *  description="",
     *  operationId="Waste-type-delete-many",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="ids[]", type="array", collectionFormat="multi", in="formData", @SWG\Items(type="integer"), description="waste types ids.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف نوع القمامة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="2005"),
     *      @SWG\Property(property="message", type="string", example="حدث خطأ أثناء الحذف, برجاء التأكد ان نوع القمامة غير مرتبظ بأي مركبات و المحاولة مرة أخري."),
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
     *          "ids"={"نوع القمامة غير متواج."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroyMany(WasteTypeDeleteRequest $request)
    {
        $ids = $request->input('ids');

        $result = (new DeleteWasteTypesAction($ids))->execute();

        $messages = [
            'success' => 'wastetype::wasteType.delete-success',
            'fail'    => 'wastetype::wasteType.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            2005
        );
    }
}
