<?php

namespace Afaqy\TransitionalStation\Http\Controllers;

use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\TransitionalStation\DTO\TransitionalStationData;
use Afaqy\TransitionalStation\Actions\StoreTransitionalStationAction;
use Afaqy\TransitionalStation\Actions\DeleteTransitionalStationAction;
use Afaqy\TransitionalStation\Actions\UpdateTransitionalStationAction;
use Afaqy\TransitionalStation\Http\Reports\TransitionalStationPdfReport;
use Afaqy\TransitionalStation\Http\Reports\ContractsListForStationReport;
use Afaqy\TransitionalStation\Http\Reports\TransitionalStationListReport;
use Afaqy\TransitionalStation\Http\Reports\TransitionalStationShowReport;
use Afaqy\TransitionalStation\Http\Reports\TransitionalStationExcelReport;
use Afaqy\TransitionalStation\Http\Requests\TransitionalStationIndexRequest;
use Afaqy\TransitionalStation\Http\Requests\TransitionalStationStoreRequest;
use Afaqy\TransitionalStation\Http\Reports\TransitionalStationDropDownReport;
use Afaqy\TransitionalStation\Http\Requests\TransitionalStationDeleteRequest;
use Afaqy\TransitionalStation\Http\Requests\TransitionalStationUpdateRequest;

class TransitionalStationController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/transitional-station",
     *  tags={"TransitionalStation"},
     *  summary="Get Clean City system transitional-station.",
     *  description="",
     *  operationId="TransitionalStationList",
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
     *      name="sort", type="string", in="query", description="To sort by (name, or districts_count).", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          {
     *              "id"="1",
     *              "name"="Station Name",
     *              "distrctsCount"=3,
     *              "status"=1,
     *          },
     *          {
     *              "id"="1",
     *              "name"="Station Name",
     *              "distrctsCount"=3,
     *              "status"=1,
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
     *                      "first": "https://dev.api.mardam.afaqy.co/api/v1/transitional-station?page=1",
     *                      "last": "https://dev.api.mardam.afaqy.co/api/v1/transitional-station?page=2",
     *                      "previous": null,
     *                      "next": "https://dev.api.mardam.afaqy.co/api/v1/transitional-station?page=2"
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
    public function index(TransitionalStationIndexRequest $request)
    {
        if ($request->districts) {
            return (new TransitionalStationDropDownReport($request))->show();
        }

        return (new TransitionalStationListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/transitional-station/export/excel",
     *  tags={"TransitionalStation"},
     *  summary="Export Transitional Station as Excel file.",
     *  description="",
     *  operationId="transitional-station-export-excel",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (name, or districts_count).", required=false
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
    public function exportExcel(TransitionalStationIndexRequest $request)
    {
        return (new TransitionalStationExcelReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/transitional-station/export/pdf",
     *  tags={"TransitionalStation"},
     *  summary="Export Transitional Station as PDF file.",
     *  description="",
     *  operationId="transitional-station-export-pdf",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (name, or districts_count).", required=false
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
    public function exportPdf(TransitionalStationIndexRequest $request)
    {
        return (new TransitionalStationPdfReport($request))->show();
    }

    /**
     * @SWG\Post(
     *  path="/v1/transitional-stations/",
     *  tags={"TransitionalStation"},
     *  summary="Store Transitional Station.",
     *  description="",
     *  operationId="transitional-station-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="name", type="string", in="formData", description="transitional station name.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="districts[]", type="array", @SWG\Items(type="integer"), in="formData", description="Array of The waste types IDs."
     *  ),
     *  @SWG\Parameter(
     *      name="status", type="boolean", in="formData", description="The Transitional Station Status.", required=true,
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ المحطة الانتقالية بنجاح"),
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
    public function store(TransitionalStationStoreRequest $request)
    {
        $dto = TransitionalStationData::fromRequest($request);

        $result = (new StoreTransitionalStationAction($dto))->execute();

        $messages = [
            'success' => 'transitionalstation::transitionalStation.store-success',
            'fail'    => 'transitionalstation::transitionalStation.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            12000
        );
    }

    /**
     * @SWG\Put(
     *  path="/v1/transitional-station/:id",
     *  tags={"TransitionalStation"},
     *  summary="Update Transitional Station.",
     *  description="",
     *  operationId="transitional-station-update",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="transitional station id.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="name", type="string", in="formData", description="transitional station name.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="districts[]", type="array", @SWG\Items(type="integer"), in="formData", description="Array of The Districts IDs."
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تحديث المحطات الانتقالية بنجاح"),
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
    public function update(TransitionalStationUpdateRequest $request, $id)
    {
        $dto = TransitionalStationData::fromRequest($request, $id);

        $result = (new UpdateTransitionalStationAction($dto))->execute();

        $messages = [
            'success' => 'transitionalstation::transitionalStation.update-success',
            'fail'    => 'transitionalstation::transitionalStation.update-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            12001
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/transitional-station/:id",
     *  tags={"TransitionalStation"},
     *  summary="Delete Transitional Station.",
     *  description="",
     *  operationId="transitional-station-delete",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for transitional station.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف المحطة الانتقالية بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="3002"),
     *      @SWG\Property(property="message", type="string", example="حدث خطأ أثناء الحذف, برجاء التأكد ان المحطة الانتقالية غير مرتبطة بأي عقد نشط و المحاولة مرة أخري."),
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
        $result = (new DeleteTransitionalStationAction($id))->execute();

        $messages = [
            'success' => 'transitionalstation::transitionalStation.delete-success',
            'fail'    => 'transitionalstation::transitionalStation.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            12002
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/transitional-station/",
     *  tags={"TransitionalStation"},
     *  summary="Delete many transitional station.",
     *  description="",
     *  operationId="transitional-station-delete-many",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="ids[]", type="array", collectionFormat="multi", in="formData", @SWG\Items(type="integer"), description="transitional station ids.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف المحطة الانتقالية بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="12002"),
     *      @SWG\Property(property="message", type="string", example="حدث خطأ أثناء الحذف, برجاء التأكد  ان المحطة الانتقالية غير مرتبطة بأي عقد نشط و المحاولة مرة أخري."),
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
     *          "ids"={" المحطة الانتقالية غير متواجدة."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroyMany(TransitionalStationDeleteRequest $request)
    {
        $ids = $request->input('ids');

        $result = (new DeleteTransitionalStationAction($ids))->execute();

        $messages = [
            'success' => 'transitionalstation::transitionalStation.delete-success',
            'fail'    => 'transitionalstation::transitionalStation.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            12002
        );
    }

    /**
     * @SWG\Get(
     *  path="/v1/transitional-stations/:id",
     *  tags={"TransitionalStation"},
     *  summary="Clean City show Transitional Stations.",
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
     *         "name"="محطة 1",
     *         "districts"={
     *          {
     *              "id"="1",
     *              "name"="المليساء",
     *          },
     *          {
     *              "id"="2",
     *              "name"="ذهبان",
     *          },
     *      },
     *      "status":1,
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
        return (new TransitionalStationShowReport($id))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/transitional-station/:id/contracts",
     *  tags={"TransitionalStation"},
     *  summary="contracts for the given district.",
     *  description="",
     *  operationId="station-contracts-list",
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
        return (new ContractsListForStationReport($id))->show();
    }
}
