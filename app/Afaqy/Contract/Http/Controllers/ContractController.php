<?php

namespace Afaqy\Contract\Http\Controllers;

use Afaqy\Contract\DTO\ContractData;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Contract\Actions\DeleteContractAction;
use Afaqy\Contract\Http\Reports\ContractPdfReport;
use Afaqy\Contract\Http\Reports\ContractListReport;
use Afaqy\Contract\Http\Reports\ContractExcelReport;
use Afaqy\Contract\Http\Reports\Show\ContractReport;
use Afaqy\Contract\Http\Requests\ContractIndexRequest;
use Afaqy\Contract\Http\Requests\ContractStoreRequest;
use Afaqy\Contract\Http\Requests\ContractDeleteRequest;
use Afaqy\Contract\Http\Requests\ContractUpdateRequest;
use Afaqy\Contract\Http\Reports\Show\ContractContactReport;
use Afaqy\Contract\Http\Reports\Show\ContractStationsReport;
use Afaqy\Contract\Http\Reports\Show\ContractDistrictsReport;
use Afaqy\Contract\Http\Reports\Show\ContractContractorReport;
use Afaqy\Contract\Actions\Aggregators\StoreContractAggregator;
use Afaqy\Contract\Actions\Aggregators\UpdateContractAggregator;

class ContractController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/contracts",
     *  tags={"Contracts"},
     *  summary="Get Clean City contracts list.",
     *  description="",
     *  operationId="ContractsList",
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
     *      name="sort", type="string", in="query", description="To sort by (id, start_at, end_at, contractor_name_ar, units_count, districts_count, contact_name).", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          {
     *              "id": 1,
     *              "start_at": "2020-01-01",
     *              "end_at": "2021-01-01",
     *              "districts_count": 2,
     *              "units_count": 4,
     *              "contractor": {
     *                  "name_ar": "رؤى",
     *                  "name_en": "tempora"
     *              },
     *              "contact": {
     *                  "name": "Alaina",
     *                  "email": "gutkowski.angel@example.net",
     *                  "phone": "+2446060868669"
     *              }
     *          }
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
     *                      "first": "https://dev.api.mardam.afaqy.co/api/v1/contracts?page=1",
     *                      "last": "https://dev.api.mardam.afaqy.co/api/v1/contracts?page=2",
     *                      "previous": null,
     *                      "next": "https://dev.api.mardam.afaqy.co/api/v1/contracts?page=2"
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
    public function index(ContractIndexRequest $request)
    {
        return (new ContractListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/contracts/export/excel",
     *  tags={"Contracts"},
     *  summary="Export Clean City contracts as Excel file.",
     *  description="",
     *  operationId="contractsExport-excel",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (id, start_at, end_at, contractor_name_ar, units_count, districts_count, contact_name).", required=false
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
    public function exportExcel(ContractIndexRequest $request)
    {
        return (new ContractExcelReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/contracts/export/pdf",
     *  tags={"Contracts"},
     *  summary="Export Clean City contracts as PDF file.",
     *  description="",
     *  operationId="contractsExport-pdf",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in name."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (id, start_at, end_at, contractor_name_ar, units_count, districts_count, contact_name).", required=false
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
    public function exportPdf(ContractIndexRequest $request)
    {
        return (new ContractPdfReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/contracts/:id",
     *  tags={"Contracts"},
     *  summary="Show contract information for the given id.",
     *  description="",
     *  operationId="contractsShow",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Contract id.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *             "id": 1,
     *              "start_at": "2020-01-04",
     *              "end_at": "2021-01-04",
     *              "status": 1,
     *              "contractor": {
     *                  "id": 3,
     *                  "name": "سندس"
     *              },
     *              "contact": {
     *                  "id": 10,
     *                  "name": "Melisa",
     *                  "title": "temporibus",
     *                  "email": "iwest@example.org",
     *                  "phone": "+1341878427025"
     *              },
     *              "districts": {
     *                  {
     *                      "district_id": 10,
     *                      "district_name": "التاريخية",
     *                      "neighborhood_id": 26,
     *                      "neighborhood_name": "البحارة",
     *                      "units": {
     *                          "bla 1213",
     *                          "bla 1215",
     *                          "bla 1216"
     *                      }
     *                  },
     *                  {
     *                      "district_id": 12,
     *                      "district_name": "ام السلم",
     *                      "neighborhood_id": 33,
     *                      "neighborhood_name": "الزهراء",
     *                      "units": {
     *                          "bla 122",
     *                          "bla 123",
     *                          "bla 1214",
     *                          "bla 1218"
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
    public function show(int $id)
    {
        $contract               = (new ContractReport($id))->show();
        $contract['contractor'] = (new ContractContractorReport($id))->show();
        $contract['contact']    = (new ContractContactReport($id))->show();
        $contract['districts']  = (new ContractDistrictsReport($id))->show();
        $contract['stations']   = (new ContractStationsReport($id))->show();

        return $this->returnSuccess('', $contract);
    }

    /**
     * @SWG\Post(
     *  path="/v1/contracts/",
     *  tags={"Contracts"},
     *  summary="Store new contract in Clean city system.",
     *  description="",
     *  operationId="contractsStore",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="contractor_id", type="integer", example="1"),
     *         @SWG\Property(property="start_at", type="string",  format="date", example="1999-03-01"),
     *         @SWG\Property(property="end_at", type="string",  format="date", example="1999-03-01"),
     *         @SWG\Property(property="status", type="boolean", example="true"),
     *         @SWG\Property(
     *             property="contact",
     *             type="object",
     *             @SWG\Property(property="name", type="string", example="Ahmed mohammed"),
     *             @SWG\Property(property="title", type="string", example="Manager"),
     *             @SWG\Property(property="email", type="string", example="bla@bla.com"),
     *             @SWG\Property(property="phone", type="integer", example="0512345678"),
     *         ),
     *         @SWG\Property(
     *             property="districts",
     *             type="array",
     *             @SWG\Items(
     *                  type="object",
     *                  @SWG\Property(property="district_id", type="integer", example="1"),
     *                  @SWG\Property(property="neighborhood_id", type="string", example="1"),
     *                  @SWG\Property(property="units_ids", type="array", collectionFormat="multi",  @SWG\Items(type="integer", example="1")),
     *            )
     *         ),
     *     )
     *   ),
     *  @SWG\Response(response=200, description="Successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ المركبة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 17
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="7001"),
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
    public function store(ContractStoreRequest $request)
    {
        $dto = ContractData::fromRequest($request);

        $result = (new StoreContractAggregator($dto))->execute();

        $messages = [
            'success' => 'contract::contract.store-success',
            'fail'    => 'contract::contract.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            7001
        );
    }

    /**
     * @SWG\Put(
     *  path="/v1/contracts/:id",
     *  tags={"Contracts"},
     *  summary="Update the given contract id.",
     *  description="",
     *  operationId="contractsUpdate",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="unit id.", required=true,
     *  ),
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="contractor_id", type="integer", example="1"),
     *         @SWG\Property(property="start_at", type="string",  format="date", example="1999-03-01"),
     *         @SWG\Property(property="end_at", type="string",  format="date", example="1999-03-01"),
     *         @SWG\Property(property="status", type="boolean", example="true"),
     *         @SWG\Property(
     *             property="contact",
     *             type="object",
     *             @SWG\Property(property="name", type="string", example="Ahmed mohammed"),
     *             @SWG\Property(property="title", type="string", example="Manager"),
     *             @SWG\Property(property="email", type="string", example="bla@bla.com"),
     *             @SWG\Property(property="phone", type="integer", example="0512345678"),
     *         ),
     *         @SWG\Property(
     *             property="districts",
     *             type="array",
     *             @SWG\Items(
     *                  type="object",
     *                  @SWG\Property(property="district_id", type="integer", example="1"),
     *                  @SWG\Property(property="neighborhood_id", type="string", example="1"),
     *                  @SWG\Property(property="units_ids", type="array", collectionFormat="multi",  @SWG\Items(type="integer", example="1")),
     *            )
     *         ),
     *     )
     *   ),
     *  @SWG\Response(response=200, description="Successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تعديل المركبة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={})
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="7002"),
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
    public function update(ContractUpdateRequest $request, int $id)
    {
        $dto = ContractData::fromRequest($request, $id);

        $result = (new UpdateContractAggregator($dto))->execute();

        $messages = [
            'success' => 'contract::contract.update-success',
            'fail'    => 'contract::contract.update-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            7002
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/contracts/:id",
     *  tags={"Contracts"},
     *  summary="Delete contract from Clean City system.",
     *  description="",
     *  operationId="contractsDelete",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id of units.", required=true
     *  ),
     *  @SWG\Response(response=200, description="Successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف المركبة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="7003"),
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
        $result = (new DeleteContractAction($id))->execute();

        $messages = [
            'success' => 'contract::contract.delete-success',
            'fail'    => 'contract::contract.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            7003
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/contracts/",
     *  tags={"Contracts"},
     *  summary="Delete many contracts from Clean City system.",
     *  description="",
     *  operationId="contractsDeleteMany",
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
     *      @SWG\Property(property="code", type="integer", example="7003"),
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
     *          "ids"={"المركبة غير متواجدة."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroyMany(ContractDeleteRequest $request)
    {
        $result = (new DeleteContractAction($request->ids))->execute();

        $messages = [
            'success' => 'contract::contract.delete-multi-success',
            'fail'    => 'contract::contract.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            7003
        );
    }
}
