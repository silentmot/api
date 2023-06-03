<?php

namespace Afaqy\Permission\Http\Controllers;

use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Permission\DTO\SortingAreaPermissionData;
use Afaqy\Permission\Http\Requests\Sorting\SortingAreaPermissionStoreRequest;
use Afaqy\Permission\Actions\Aggregators\Sorting\StoreSortingAreaPermissionAggregator;

class SortingPermissionController extends Controller
{
    /**
     * @SWG\Post(
     *  path="/v1/sorting-area-permissions/",
     *  tags={"Permissions"},
     *  summary="Store sorting area permission.",
     *  description="",
     *  operationId="sorting-area-permission-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="waste_type_id", type="integer", example=5),
     *         @SWG\Property(property="entity_name", type="string", example="xyz"),
     *         @SWG\Property(property="representative_name", type="string", example="Ahmed"),
     *         @SWG\Property(property="allowed_weight", type="float", example=1234),
     *         @SWG\Property(property="national_id", type="integer", example=1987654332),
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
    public function store(SortingAreaPermissionStoreRequest $request)
    {
        $dto = SortingAreaPermissionData::fromRequest($request);

        $result = (new StoreSortingAreaPermissionAggregator($dto))->execute();

        $messages = [
            'success' => 'permission::permission.store-success',
            'fail'    => 'permission::permission.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            13000
        );
    }
}
