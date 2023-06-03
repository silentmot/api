<?php

namespace Afaqy\EntrancePermission\Http\Controllers;

use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\EntrancePermission\DTO\EntrancePermissionData;
use Afaqy\EntrancePermission\Actions\StoreEntrancePermissionAction;
use Afaqy\EntrancePermission\Actions\DeleteEntrancePermissionAction;
use Afaqy\EntrancePermission\Actions\UpdateEntrancePermissionAction;
use Afaqy\EntrancePermission\Http\Reports\EntrancePermissionPdfReport;
use Afaqy\EntrancePermission\Http\Reports\EntrancePermissionListReport;
use Afaqy\EntrancePermission\Http\Reports\EntrancePermissionShowReport;
use Afaqy\EntrancePermission\Http\Reports\EntrancePermissionExcelReport;
use Afaqy\EntrancePermission\Http\Requests\EntrancePermissionIndexRequest;
use Afaqy\EntrancePermission\Http\Requests\EntrancePermissionStoreRequest;
use Afaqy\EntrancePermission\Http\Requests\EntrancePermissionDeleteRequest;
use Afaqy\EntrancePermission\Http\Requests\EntrancePermissionUpdateRequest;

class EntrancePermissionController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/entrance-permissions",
     *  tags={"EntrancePermission"},
     *  summary="Get list of Entrance Permissions.",
     *  description="",
     *  operationId="EntrancePermissionList",
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
     *      name="sort", type="string", in="query", description="To sort by (id, name, type, plate_number, start_end, end_date).", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          {
     *              "id"="1",
     *              "name"="روان",
     *              "type"="visitor",
     *              "plate_number"="Abs q234",
     *              "start_date"="09-09-2019",
     *              "end_date"="09-09-2019",
     *          },
     *          {
     *              "id"="2",
     *              "name"="منار",
     *              "type"="visitor",
     *              "plate_number"="Abs q234",
     *              "start_date"="09-09-2019",
     *              "end_date"="09-09-2019",
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
     *                      "first": "https://dev.api.mardam.afaqy.co/api/v1/entrance-permissions?page=1",
     *                      "last": "https://dev.api.mardam.afaqy.co/api/v1/entrance-permissions?page=2",
     *                      "previous": null,
     *                      "next": "https://dev.api.mardam.afaqy.co/api/v1/entrance-permissions?page=2"
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
    public function index(EntrancePermissionIndexRequest $request)
    {
        return (new EntrancePermissionListReport($request))->show();
    }

    /**
     * @SWG\Post(
     *  path="/v1/entrance-permissions/",
     *  tags={"EntrancePermission"},
     *  summary="Store Entrance Permission.",
     *  description="",
     *  operationId="entrance-permission-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="name", type="string", in="formData", description="name.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="title", type="string", in="formData", description="title.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="national_id", type="string", in="formData", description="national_id.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="phone", type="string", in="formData", description="phone.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="company", type="string", in="formData", description="company."
     *  ),
     *  @SWG\Parameter(
     *      name="plate_number", type="string", in="formData", description="plate_number.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="start_date", type="string", in="formData", description="start_date.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="end_date", type="string", in="formData", description="end_date.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="rfid", type="integer", in="formData", description="unit rfid.", required=false,
     *  ),
     *  @SWG\Parameter(
     *      name="qr_code", type="integer", in="formData", description="unit qr_code.", required=false,
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ تصريح الدخول بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 17
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="6000"),
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
    public function store(EntrancePermissionStoreRequest $request)
    {
        $dto = EntrancePermissionData::fromRequest($request);

        $result = (new StoreEntrancePermissionAction($dto))->execute();

        $messages = [
            'success' => 'entrancepermission::entrancePermission.store-success',
            'fail'    => 'entrancepermission::entrancePermission.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            6000
        );
    }

    /**
     * @SWG\Get(
     *  path="/v1/entrance-permissions/:id",
     *  tags={"EntrancePermission"},
     *  summary="Show unit information for the given id.",
     *  description="",
     *  operationId="entrance-permission-show",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for unit.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *              "id": 1,
     *              "name"="منار",
     *              "type"="employee",
     *              "title"="موظف",
     *              "national_id": 1234324234,
     *              "phone": 05123123123,
     *              "company": "afaqy",
     *              "plate_number"="Abs q234",
     *              "start_date"="09-09-2019",
     *              "end_date"="09-09-2019",
     *              "rfid": 368207,
     *              "qr_code": 32431423,
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
        return (new EntrancePermissionShowReport($id))->show();
    }

    /**
     * @SWG\Put(
     *  path="/v1/entrance-permissions/:id",
     *  tags={"EntrancePermission"},
     *  summary="Update Entrance Permission for the given id.",
     *  description="",
     *  operationId="entrance-permissions-update",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="unit id.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="name", type="string", in="formData", description="name.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="title", type="string", in="formData", description="title.",
     *  ),
     *  @SWG\Parameter(
     *      name="national_id", type="string", in="formData", description="national_id.",
     *  ),
     *  @SWG\Parameter(
     *      name="phone", type="string", in="formData", description="phone.",
     *  ),
     *  @SWG\Parameter(
     *      name="company", type="string", in="formData", description="company."
     *  ),
     *  @SWG\Parameter(
     *      name="plate_number", type="string", in="formData", description="plate_number.",
     *  ),
     *  @SWG\Parameter(
     *      name="start_date", type="string", in="formData", description="start_date.",
     *  ),
     *  @SWG\Parameter(
     *      name="end_date", type="string", in="formData", description="end_date.",
     *  ),
     *  @SWG\Parameter(
     *      name="rfid", type="integer", in="formData", description="unit rfid.", required=false,
     *  ),
     *  @SWG\Parameter(
     *      name="qr_code", type="integer", in="formData", description="unit qr_code.", required=false,
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تعديل تصريح الدخول بنجاح"),
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
    public function update(EntrancePermissionUpdateRequest $request, int $id)
    {
        $dto = EntrancePermissionData::fromRequest($request, $id);

        $result = (new UpdateEntrancePermissionAction($dto))->execute();

        $messages = [
            'success' => 'entrancepermission::entrancePermission.update-success',
            'fail'    => 'entrancepermission::entrancePermission.update-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            6001
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/entrance-permissions/:id",
     *  tags={"EntrancePermission"},
     *  summary="Delete Entrance Permissions.",
     *  description="",
     *  operationId="entrance-permissions-delete",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for entrance permissions.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف تصريح الدخول بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="5002"),
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
     *  @SWG\Response(response=404, description="Not Found", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Not found."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroy(int $id)
    {
        $result = (new DeleteEntrancePermissionAction($id))->execute();

        $messages = [
            'success' => 'entrancepermission::entrancePermission.delete-success',
            'fail'    => 'entrancepermission::entrancePermission.delete-success',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            6002
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/entrance-permissions/",
     *  tags={"EntrancePermission"},
     *  summary="Delete many Entrance Permissions.",
     *  description="",
     *  operationId="entrance-permissions-delete-many",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="ids[]", type="array", collectionFormat="multi", in="formData", @SWG\Items(type="integer"), description="entrance permissions ids.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف نوع المركبة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="6002"),
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
     *          "ids"={"نوع المركبة غير متواج."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroyMany(EntrancePermissionDeleteRequest $request)
    {
        $ids = $request->input('ids');

        $result = (new DeleteEntrancePermissionAction($ids))->execute();

        $messages = [
            'success' => 'entrancepermission::entrancePermission.delete-success',
            'fail'    => 'entrancepermission::entrancePermission.delete-success',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            6002
        );
    }

    /**
     * @SWG\Get(
     *  path="/v1/entrance-permissions/export/excel",
     *  tags={"EntrancePermission"},
     *  summary="Export Entrance Permission as Excel file.",
     *  description="",
     *  operationId="export-entrance-permissions-excel",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (id, name, type, plate_number, start_end, end_date).", required=false
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
    public function exportExcel(EntrancePermissionIndexRequest $request)
    {
        return (new EntrancePermissionExcelReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/entrance-permissions/export/pdf",
     *  tags={"EntrancePermission"},
     *  summary="Export Entrance Permission as PDF file.",
     *  description="",
     *  operationId="export-entrance-permissions-pdf",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (id, name, type, plate_number, start_end, end_date).", required=false
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
    public function exportPdf(EntrancePermissionIndexRequest $request)
    {
        return (new EntrancePermissionPdfReport($request))->show();
    }
}
