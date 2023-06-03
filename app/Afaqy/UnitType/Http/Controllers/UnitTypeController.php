<?php

namespace Afaqy\UnitType\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Afaqy\UnitType\DTO\UnitTypeData;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\UnitType\Actions\StoreUnitTypeAction;
use Afaqy\UnitType\Actions\UpdateUnitTypeAction;
use Afaqy\UnitType\Actions\DeleteUnitTypesAction;
use Afaqy\UnitType\Http\Reports\UnitTypePdfReport;
use Afaqy\UnitType\Http\Reports\UnitTypeListReport;
use Afaqy\UnitType\Http\Reports\UnitTypeShowReport;
use Afaqy\UnitType\Http\Reports\UnitTypeExcelReport;
use Afaqy\UnitType\Http\Requests\UnitTypeIndexRequest;
use Afaqy\UnitType\Http\Requests\UnitTypeStoreRequest;
use Afaqy\UnitType\Http\Requests\UnitTypeDeleteRequest;
use Afaqy\UnitType\Http\Requests\UnitTypeUpdateRequest;

class UnitTypeController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/unit-types",
     *  tags={"UnitTypes"},
     *  summary="Get list of the unit types.",
     *  description="",
     *  operationId="UnitTypesList",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name."
     *  ),
     *  @SWG\Parameter(
     *      name="per_page", type="integer", in="query", description="The number of items per page. min 10 and max 200. default 50.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (id, name, units_count).", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          {
     *              "id"="1",
     *              "name"="مكنسة",
     *              "units_count"="9",
     *          },
     *          {
     *              "id"="2",
     *              "name"="ضاغط",
     *              "units_count"="6",
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
     *                      "first": "https://dev.api.mardam.afaqy.co/api/v1/unit-types?page=1",
     *                      "last": "https://dev.api.mardam.afaqy.co/api/v1/unit-types?page=2",
     *                      "previous": null,
     *                      "next": "https://dev.api.mardam.afaqy.co/api/v1/unit-types?page=2"
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
    public function index(UnitTypeIndexRequest $request)
    {
        return (new UnitTypeListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/unit-types/export/excel",
     *  tags={"UnitTypes"},
     *  summary="Export Unit Types.",
     *  description="",
     *  operationId="export-unit-type",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (id, name, units_count).", required=false
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
    public function exportExcel(UnitTypeIndexRequest $request)
    {
        return (new UnitTypeExcelReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/unit-types/export/pdf",
     *  tags={"UnitTypes"},
     *  summary="Export Unit Types as PDF file.",
     *  description="",
     *  operationId="export-unit-type-pdf",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (id, name, units_count).", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="output", type="string", in="query", description="send it equal raw to return raw data", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful download PDF file."),
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
    public function exportPdf(UnitTypeIndexRequest $request)
    {
        return (new UnitTypePdfReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/unit-types/:id",
     *  tags={"UnitTypes"},
     *  summary="Clean City show Unit Type.",
     *  description="",
     *  operationId="show",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for unit type.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *         "id"="1",
     *         "type"="مكنسة",
     *         "waste-types"={
     *          {
     *              "id"="1",
     *              "name"="منزلية",
     *          },
     *          {
     *              "id"="2",
     *              "name"="دمار",
     *          },
     *      },
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
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function show(int $id)
    {
        return (new UnitTypeShowReport($id))->show();
    }

    /**
     * @SWG\Post(
     *  path="/v1/unit-types/",
     *  tags={"UnitTypes"},
     *  summary="Store Unit Type.",
     *  description="",
     *  operationId="Unit-type-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="name", type="string", in="formData", description="unit type name.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="waste_types[]", type="array", @SWG\Items(type="integer"), in="formData", description="Array of The waste types IDs."
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ نوع المركبة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 17
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="3000"),
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
     *  @SWG\Response(response=500, description="Internal Server Error"),
     * )
     */
    public function store(UnitTypeStoreRequest $request)
    {
        $dto = UnitTypeData::fromRequest($request);

        $result = (new StoreUnitTypeAction($dto))->execute();

        $messages = [
            'success' => 'unittype::unitType.store-success',
            'fail'    => 'unittype::unitType.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            3000
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/unit-types/:id",
     *  tags={"UnitTypes"},
     *  summary="Delete Unit Type.",
     *  description="",
     *  operationId="Unit-type-delete",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for unit type.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف نوع المركبة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="3002"),
     *      @SWG\Property(property="message", type="string", example="حدث خطأ أثناء الحذف, برجاء التأكد ان نوع المركبة غير مرتبظ بأي مركبات و المحاولة مرة أخري."),
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
     *      @SWG\Property(property="message", type="string", example="Not found."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroy(int $id)
    {
        $result = (new DeleteUnitTypesAction($id))->execute();

        $messages = [
            'success' => 'unittype::unitType.delete-success',
            'fail'    => 'unittype::unitType.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            3002
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/unit-types/",
     *  tags={"UnitTypes"},
     *  summary="Delete many Unit Types.",
     *  description="",
     *  operationId="Unit-type-delete-many",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="ids[]", type="array", collectionFormat="multi", in="formData", @SWG\Items(type="integer"), description="unit types ids.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف نوع المركبة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="3002"),
     *      @SWG\Property(property="message", type="string", example="حدث خطأ أثناء الحذف, برجاء التأكد ان نوع المركبة غير مرتبظ بأي مركبات و المحاولة مرة أخري."),
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
     *          "ids"={"نوع المركبة غير متواج."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroyMany(UnitTypeDeleteRequest $request)
    {
        $ids = $request->input('ids');

        $result = (new DeleteUnitTypesAction($ids))->execute();

        $messages = [
            'success' => 'unittype::unitType.delete-success',
            'fail'    => 'unittype::unitType.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            3002
        );
    }

    /**
     * @SWG\Put(
     *  path="/v1/unit-types/:id",
     *  tags={"UnitTypes"},
     *  summary="Update Unit Type.",
     *  description="",
     *  operationId="Unit-type-update",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="unit type id.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="name", type="string", in="formData", description="unit type name.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="waste_types[]", type="array", @SWG\Items(type="integer"), in="formData", description="Array of The waste types IDs."
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تحديث نوع المركبة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="3001"),
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
    public function update(UnitTypeUpdateRequest $request, $id)
    {
        $dto = UnitTypeData::fromRequest($request, $id);

        $result = (new UpdateUnitTypeAction($dto))->execute();

        $messages = [
            'success' => 'unittype::unitType.update-success',
            'fail'    => 'unittype::unitType.update-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            3001
        );
    }
}
