<?php

namespace Afaqy\Unit\Http\Controllers;

use Afaqy\Unit\DTO\UnitData;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Afaqy\Unit\Actions\StoreUnitAction;
use Afaqy\Unit\Actions\DeleteUnitAction;
use Afaqy\Unit\Actions\UpdateUnitAction;
use Afaqy\Unit\Http\Reports\UnitPdfReport;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Unit\Http\Reports\UnitListReport;
use Afaqy\Unit\Http\Reports\UnitShowReport;
use Afaqy\Unit\Http\Reports\UnitExcelReport;
use Afaqy\Unit\Http\Requests\UnitIndexRequest;
use Afaqy\Unit\Http\Requests\UnitStoreRequest;
use Afaqy\Unit\Http\Requests\UnitDeleteRequest;
use Afaqy\Unit\Http\Requests\UnitUpdateRequest;

class UnitController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/units",
     *  tags={"Units"},
     *  summary="Clean City units list.",
     *  description="",
     *  operationId="UnitsList",
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
     *      name="sort", type="string", in="query", description="To sort by (id, code, model, plate_number, unit_type_name, net_weight, waste_type_name, contractor_name, active).", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          {
     *              "id": 19,
     *              "code": "bla 1219",
     *              "model": 1988,
     *              "plate_number": "bla 1219",
     *              "net_weight": 138,
     *              "contractor": "الشرق",
     *              "active": 0,
     *              "unit_type": "مكنسة",
     *              "waste_type": "منزلية"
     *          },
     *          {
     *              "id": 18,
     *              "code": "bla 1219",
     *              "model": 1988,
     *              "plate_number": "bla 1219",
     *              "net_weight": 138,
     *              "contractor": "الشرق",
     *              "active": 1,
     *              "unit_type": "مكنسة",
     *              "waste_type": "منزلية"
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
     *                      "first": "https://dev.api.mardam.afaqy.co/api/v1/units?page=1",
     *                      "last": "https://dev.api.mardam.afaqy.co/api/v1/units?page=2",
     *                      "previous": null,
     *                      "next": "https://dev.api.mardam.afaqy.co/api/v1/units?page=2"
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
    public function index(UnitIndexRequest $request)
    {
        return (new UnitListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/units/export/excel",
     *  tags={"Units"},
     *  summary="Export Units.",
     *  description="",
     *  operationId="unit-export",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (id, code, model, plate_number, unit_type_name, net_weight, waste_type_name, contractor_name, active).", required=false
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
    public function exportExcel(UnitIndexRequest $request)
    {
        return (new UnitExcelReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/units/export/pdf",
     *  tags={"Units"},
     *  summary="Export Units as PDF file.",
     *  description="",
     *  operationId="unit-export-pdf",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (id, code, model, plate_number, unit_type_name, net_weight, waste_type_name, contractor_name, active).", required=false
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
    public function exportPdf(UnitIndexRequest $request)
    {
        return (new UnitPdfReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/units/:id",
     *  tags={"Units"},
     *  summary="Show unit information for the given id.",
     *  description="",
     *  operationId="unit-show",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for unit.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *             "id": 1,
     *             "code": "bla 121",
     *             "model": 2019,
     *             "plate_number": "bla 121",
     *             "net_weight": 34,
     *             "contractor": "الشرق",
     *             "active": 0,
     *             "vin_number": "18720",
     *             "max_weight": 6326,
     *             "rfid": 368207,
     *             "unit_type": {
     *               "id": 2,
     *               "name": "ثانكر"
     *             },
     *             "waste_type": {
     *               "id": 1,
     *               "name": "دمار"
     *             }
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
        return (new UnitShowReport($id))->show();
    }

    /**
     * @SWG\Post(
     *  path="/v1/units/",
     *  tags={"Units"},
     *  summary="Store new unit to Clean City system.",
     *  description="",
     *  operationId="units-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="code", type="string", in="formData", description="unit code.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="model", type="string", format="date", in="formData", description="unit model.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="plate_number", type="string", in="formData", description="unit plate number.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="vin_number", type="integer", in="formData", description="unit vin number.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="net_weight", type="integer", in="formData", description="unit net weight.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="max_weight", type="integer", in="formData", description="unit max weight.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="rfid", type="integer", in="formData", description="unit rfid.", required=false,
     *  ),
     *  @SWG\Parameter(
     *      name="unit_type", type="integer", in="formData", description="unit type.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="waste_type", type="integer", in="formData", description="unit waste type.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="contractor_id", type="integer", in="formData", description="unit contractor id.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="active", type="boolean", in="formData", description="unit active.", required=true,
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ المركبة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 17
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="4001"),
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
     *          "code"={"The code must be string."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(UnitStoreRequest $request)
    {
        $dto = UnitData::fromRequest($request);

        $result = (new StoreUnitAction($dto))->execute();

        $messages = [
            'success' => 'unit::unit.store-success',
            'fail'    => 'unit::unit.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            4001
        );
    }

    /**
     * @SWG\Put(
     *  path="/v1/units/:id",
     *  tags={"Units"},
     *  summary="Update unit for the given id.",
     *  description="",
     *  operationId="units-update",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="unit id.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="code", type="string", in="formData", description="unit code.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="model", type="string", format="date", in="formData", description="unit model.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="plate_number", type="string", in="formData", description="unit plate number.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="vin_number", type="integer", in="formData", description="unit vin number.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="net_weight", type="integer", in="formData", description="unit net weight.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="max_weight", type="integer", in="formData", description="unit max weight.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="rfid", type="integer", in="formData", description="unit rfid.", required=false,
     *  ),
     *  @SWG\Parameter(
     *      name="unit_type", type="integer", in="formData", description="unit type.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="waste_type", type="integer", in="formData", description="unit waste type.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="contractor_id", type="integer", in="formData", description="unit contractor id.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="active", type="boolean", in="formData", description="unit active.", required=true,
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تعديل المركبة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={})
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="4002"),
     *      @SWG\Property(property="message", type="string", example="حديث خطأ أثناء التعديل, ربجاء المحاولة مرة اخري."),
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
     *          "code"={"The code must be string."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function update(UnitUpdateRequest $request, int $id)
    {
        $dto = UnitData::fromRequest($request, $id);

        $result = (new UpdateUnitAction($dto))->execute();

        $messages = [
            'success' => 'unit::unit.update-success',
            'fail'    => 'unit::unit.update-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            4002
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/units/:id",
     *  tags={"Units"},
     *  summary="Delete unit from Clean City system.",
     *  description="",
     *  operationId="units-delete",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="unit id", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف المركبة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="4003"),
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
        $result = (new DeleteUnitAction($id))->execute();

        $messages = [
            'success' => 'unit::unit.delete-success',
            'fail'    => 'unit::unit.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            4003
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/units/",
     *  tags={"Units"},
     *  summary="Delete many units from Clean City system.",
     *  description="",
     *  operationId="units-delete-many",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="ids[]", type="array", collectionFormat="multi", in="formData", @SWG\Items(type="integer"), description="Units ids.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف المركبات بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="4003"),
     *      @SWG\Property(property="message", type="string", example="حدث خطأ أثناء الحذف."),
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
     *          "ids"={"المركحبة غير متواج."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroyMany(UnitDeleteRequest $request)
    {
        $result = (new DeleteUnitAction($request->ids))->execute();

        $messages = [
            'success' => 'unit::unit.delete-multi-success',
            'fail'    => 'unit::unit.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            4003
        );
    }
}
