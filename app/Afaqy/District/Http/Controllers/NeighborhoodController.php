<?php

namespace Afaqy\District\Http\Controllers;

use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\District\Http\Reports\ContractListForNeighborhoodReport;

class NeighborhoodController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/neighborhood/:id/contracts",
     *  tags={"Neighborhoods"},
     *  summary="contracts for the given neighborhood.",
     *  description="",
     *  operationId="neighborhood-contracts-list",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="To get contracts for the given neighborhood.", required=false
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
     * @param int $id
     * @return mixed
     */
    public function contracts(int $id)
    {
        return (new ContractListForNeighborhoodReport($id))->show();
    }
}
