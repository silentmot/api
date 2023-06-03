<?php

namespace Afaqy\Permission\Http\Controllers;

use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Permission\DTO\ProjectsPermissionData;
use Afaqy\Permission\Http\Reports\Projects\ProjectPermissionByNumberReport;
use Afaqy\Permission\Http\Requests\Projects\ProjectsPermissionStoreRequest;
use Afaqy\Permission\Actions\Aggregators\Projects\StoreProjectsPermissionAggregator;

class ProjectsPermissionController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/damaged-projects-permissions/details/:serial",
     *  tags={"Permissions"},
     *  summary="Show damaged-projects-permissions details.",
     *  description="",
     *  operationId="show-permission-damaged-projects",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="serial", type="string", in="query", description="ID/Number for project permission.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *              "name": "bla",
     *              "neighborhoods": {
     *                  {
     *                      "id": 1,
     *                      "demolition_serial": "78452678",
     *                      "permission_number": "2463",
     *                      "permission_date": "21-02-1972",
     *                      "company_name": "Beer, Nolan and Waters",
     *                      "company_commercial_number": 4888012397,
     *                      "units": {
     *                         "id": 13,
     *                         "plate_number": "wrz 377"
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
    public function getByNumber($number)
    {
        return (new ProjectPermissionByNumberReport($number))->show();
    }

    /**
     * @SWG\Post(
     *  path="/v1/damaged-projects-permissions/",
     *  tags={"Permissions"},
     *  summary="Store project permission.",
     *  description="",
     *  operationId="project-permission-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="demolition_serial", type="string", example="1237577"),
     *         @SWG\Property(property="permission_number", type="string", example="43232354"),
     *         @SWG\Property(property="company_name", type="string", example="xyz"),
     *         @SWG\Property(property="company_commercial_number", type="string", example="7685754"),
     *         @SWG\Property(property="permission_date", type="string", example="20-01-2019"),
     *         @SWG\Property(
     *             property="units",
     *             type="array",
     *             @SWG\items(type="object",
     *                 @SWG\Property(property="plate_number", type="string", example="bmw1234"),
     *             ),
     *             @SWG\items(type="object",
     *                 @SWG\Property(property="plate_number", type="string", example="bmw1784"),
     *             ),
     *         ),
     *     )
     *   ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ  بيانات التصريح بنجاح."),
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
    public function store(ProjectsPermissionStoreRequest $request)
    {
        $dto = ProjectsPermissionData::fromRequest($request);

        $result = (new StoreProjectsPermissionAggregator($dto))->execute();

        $messages = [
            'success' => 'permission::permission.store-success',
            'fail'    => 'permission::permission.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            6000
        );
    }
}
