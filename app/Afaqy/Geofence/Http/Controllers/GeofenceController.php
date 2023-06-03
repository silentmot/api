<?php

namespace Afaqy\Geofence\Http\Controllers;

use Afaqy\Geofence\DTO\GeofenceData;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Geofence\Actions\StoreGeofenceAction;
use Afaqy\Geofence\Actions\DeleteGeofenceAction;
use Afaqy\Geofence\Actions\UpdateGeofenceAction;
use Afaqy\Geofence\Http\Reports\GeofencePdfReport;
use Afaqy\Geofence\Http\Reports\GeofenceListReport;
use Afaqy\Geofence\Http\Reports\GeofenceShowReport;
use Afaqy\Geofence\Http\Reports\GeofenceExcelReport;
use Afaqy\Geofence\Http\Requests\GeofenceIndexRequest;
use Afaqy\Geofence\Http\Requests\GeofenceStoreRequest;
use Afaqy\Geofence\Http\Requests\GeofenceDeleteRequest;
use Afaqy\Geofence\Http\Requests\GeofenceUpdateRequest;

class GeofenceController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/geofences",
     *  tags={"Geofences"},
     *  summary="Get list of the geofences.",
     *  description="",
     *  operationId="GeofencesList",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name,geofence_id."
     *  ),
     *  @SWG\Parameter(
     *      name="per_page", type="integer", in="query", description="The number of items per page. min 10 and max 200. default 50.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (name, geofence_id).", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          {
     *              "id"="1",
     *              "name"="موقع أ",
     *              "type"="zone",
     *              "geofence_id"="92132312",
     *          },
     *          {
     *              "id"="2",
     *              "name"="موقع ب",
     *              "type"="pit",
     *              "geofence_id"="4345345",
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
     *                      "first": "https://dev.api.mardam.afaqy.co/api/v1/geofences?page=1",
     *                      "last": "https://dev.api.mardam.afaqy.co/api/v1/geofences?page=2",
     *                      "previous": null,
     *                      "next": "https://dev.api.mardam.afaqy.co/api/v1/geofences?page=2"
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
    public function index(GeofenceIndexRequest $request)
    {
        return (new GeofenceListReport($request))->show();
    }

    /**
     * @SWG\Post(
     *  path="/v1/geofences/",
     *  tags={"Geofences"},
     *  summary="Store Geofences.",
     *  description="",
     *  operationId="geofences-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="name", type="string", in="formData", description="unit type name.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="type", type="string", enum={"pit", "zone"}, in="query", description="type of geofence."
     *  ),
     *  @SWG\Parameter(
     *      name="geofence_id", type="string", in="formData", description="geofence name.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ نوع المنطقة الجغرافية بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 17
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="9000"),
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
    public function store(GeofenceStoreRequest $request)
    {
        $dto = GeofenceData::fromRequest($request);

        $result = (new StoreGeofenceAction($dto))->execute();

        $messages = [
            'success' => 'geofence::geofence.store-success',
            'fail'    => 'geofence::geofence.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            9000
        );
    }

    /**
     * @SWG\Get(
     *  path="/v1/geofences/export/excel",
     *  tags={"Geofences"},
     *  summary="Export Geofences as Excel file.",
     *  description="",
     *  operationId="export-geofences-excel",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name,geofence_id."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (name, geofence_id).", required=false
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
    public function exportExcel(GeofenceIndexRequest $request)
    {
        return (new GeofenceExcelReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/geofences/export/pdf",
     *  tags={"Geofences"},
     *  summary="Export Geofences as PDF file.",
     *  description="",
     *  operationId="export-geofences-pdf",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name,geofence_id."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (name, geofence_id).", required=false
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
    public function exportPdf(GeofenceIndexRequest $request)
    {
        return (new GeofencePdfReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/geofences/:id",
     *  tags={"Geofences"},
     *  summary="show geofence information for the given id.",
     *  description="",
     *  operationId="geofence-show",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for geofence.", required=true
     *  ),
     *  @SWG\Response(response=200, description="Successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *              "id"="1",
     *              "name"="موقع أ",
     *              "type"="zone",
     *              "geofence_id"="92132312",
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
        return (new GeofenceShowReport($id))->show();
    }

    /**
     * @SWG\Put(
     *  path="/v1/geofences/:id",
     *  tags={"Geofences"},
     *  summary="Update geofence in Clean City system.",
     *  description="",
     *  operationId="geofence-update",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="geofence id.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="name", type="string", in="formData", description="unit type name.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="type", type="string", enum={"pit", "zone"}, in="query", description="type of geofence."
     *  ),
     *  @SWG\Parameter(
     *      name="geofence_id", type="string", in="formData", description="geofence name.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تحديث المنطقة الجغرافية بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="9001"),
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
    public function update(GeofenceUpdateRequest $request, $id)
    {
        $dto = GeofenceData::fromRequest($request, $id);

        $result = (new UpdateGeofenceAction($dto))->execute();

        $messages = [
            'success' => 'geofence::geofence.update-success',
            'fail'    => 'geofence::geofence.update-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            9001
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/geofences/:id",
     *  tags={"Geofences"},
     *  summary="Delete geofence in Clean City system.",
     *  description="",
     *  operationId="geofence-delete",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for geofence.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف نوع المنطقة الجغرافية بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="2005"),
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
     *      @SWG\Property(property="message", type="string", example="Document or file requested by the client was not found."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroy(int $id)
    {
        $result = (new DeleteGeofenceAction($id))->execute();

        $messages = [
            'success' => 'geofence::geofence.delete-success',
            'fail'    => 'geofence::geofence.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            9003
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/geofences/",
     *  tags={"Geofences"},
     *  summary="Delete many geofences from Clean City system.",
     *  description="",
     *  operationId="geofences-delete-many",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="ids[]", type="array", collectionFormat="multi", in="formData", @SWG\Items(type="integer"), description="Units ids.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف المناطق الجغرافية بنجاح"),
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
     *          "ids"={" غير متواجدة المناطق الجغرافية."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroyMany(GeofenceDeleteRequest $request)
    {
        $result = (new DeleteGeofenceAction($request->ids))->execute();

        $messages = [
            'success' => 'geofence::geofence.delete-success',
            'fail'    => 'geofence::geofence.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            9003
        );
    }
}
