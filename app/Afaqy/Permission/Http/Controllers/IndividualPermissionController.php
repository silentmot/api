<?php

namespace Afaqy\Permission\Http\Controllers;

use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Permission\DTO\IndividualPermissionData;
use Afaqy\Permission\Http\Requests\Individual\IndividualPermissionStoreRequest;
use Afaqy\Permission\Http\Reports\Individual\IndividualPermissionByNumberReport;
use Afaqy\Permission\Actions\Aggregators\Individual\StoreIndividualPermissionAggregator;

class IndividualPermissionController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/individual-permissions/details/:number",
     *  tags={"Permissions"},
     *  summary="Show individual-permissions details.",
     *  description="",
     *  operationId="show-individual-permission-number",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="number", type="string", in="query", description="ID/Number for individual permission.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *                  {
     *                      "id": 1,
     *                      "demolition_serial": "78452678",
     *                      "permission_number": "2463",
     *                      "permission_date": "21-02-1972",
     *                      "district_id": "1",
     *                      "neighborhood_id": "17",
     *                      "owner_name": "Elmo Ward",
     *                      "owner_phone": "391616",
     *                      "street": "992 Rosalind Heights Apt. 427",
     *                      "national_id": 2609171094,
     *                      "units": {
     *                         "id": 13,
     *                         "plate_number": "wrz 377"
     *                      }
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
        return (new IndividualPermissionByNumberReport($number))->show();
    }

    /**
     * @SWG\Post(
     *  path="/v1/individual-permissions/",
     *  tags={"Permissions"},
     *  summary="Store individual permission.",
     *  description="",
     *  operationId="individual-permission-store",
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
     *         @SWG\Property(property="type", type="string", example="construction"),
     *         @SWG\Property(property="district_id", type="integer", example=1),
     *         @SWG\Property(property="neighborhood_id", type="integer", example=1),
     *         @SWG\Property(property="street", type="string", example="Makram eibd"),
     *         @SWG\Property(property="owner_name", type="string", example="Ahmed"),
     *         @SWG\Property(property="owner_phone", type="string", example="1234563432"),
     *         @SWG\Property(property="national_id", type="integer", example=1765433222),
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
    public function store(IndividualPermissionStoreRequest $request)
    {
        $dto = IndividualPermissionData::fromRequest($request);

        $result = (new StoreIndividualPermissionAggregator($dto))->execute();

        $messages = [
            'success' => 'permission::permission.store-success',
            'fail'    => 'permission::permission.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            5000
        );
    }
}
