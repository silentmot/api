<?php

namespace Afaqy\Contractor\Http\Controllers;

use Afaqy\Contractor\DTO\ContractorData;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Contractor\Actions\DeleteContractorAction;
use Afaqy\Contractor\Http\Reports\ContractorPdfReport;
use Afaqy\Contractor\Http\Reports\ContractorListReport;
use Afaqy\Contractor\Http\Reports\ContractorShowReport;
use Afaqy\Contractor\Http\Reports\ContractorExcelReport;
use Afaqy\Contractor\Http\Requests\ContractorUnitRequest;
use Afaqy\Contractor\Http\Requests\ContractorIndexRequest;
use Afaqy\Contractor\Http\Requests\ContractorStoreRequest;
use Afaqy\Contractor\Http\Requests\ContractorDeleteRequest;
use Afaqy\Contractor\Http\Requests\ContractorUpdateRequest;
use Afaqy\Contractor\Http\Reports\ContractorUnitsListReport;
use Afaqy\Contractor\Actions\Aggregators\StoreContractorAggregator;
use Afaqy\Contractor\Actions\Aggregators\UpdateContractorAggregator;

class ContractorController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/contractors",
     *  tags={"Contractors"},
     *  summary="Get list of the contractors.",
     *  description="",
     *  operationId="ContractorsList",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in  name_ar, name_en, units_count, employees, name, email, phone."
     *  ),
     *  @SWG\Parameter(
     *      name="per_page", type="integer", in="query", description="The number of items per page. min 10 and max 200. default 50.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (search in name_ar, name_en, units_count, employees, name, email).", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          {
     *              "id"="1",
     *              "name_ar"="مصطفى احمد",
     *              "name_en"="Mostafa Ahmed",
     *              "units_count"=50,
     *              "employees"=9,
     *              "contacts"={
     *              {
     *              "id"="1",
     *              "name"="User Name 1",
     *              "title"="manager",
     *              "phone"="123456789",
     *              "email"="user1@app.com",
     *              },
     *              {
     *              "id"="1",
     *              "name"="User Name 2",
     *              "title"="employee",
     *              "phone"="123456734",
     *              "email"="user2@app.com",
     *              },
     *            },
     *          },
     *          {
     *              "id"="2",
     *              "name_ar"="احمد محمود",
     *              "name_en"="Ahmed Mahmoud",
     *              "units_count"=50,
     *              "employees"=9,
     *              "contacts"={
     *              {
     *              "id"="1",
     *              "name"="User Name 1",
     *              "title"="manager",
     *              "phone"="123456789",
     *              "email"="user1@app.com",
     *              },
     *              {
     *              "id"="1",
     *              "name"="User Name 2",
     *              "title"="employee",
     *              "phone"="123456734",
     *              "email"="user2@app.com",
     *              },
     *            },
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
     *                      "first": "https://dev.api.mardam.afaqy.co/api/v1/contractors?page=1",
     *                      "last": "https://dev.api.mardam.afaqy.co/api/v1/contractors?page=2",
     *                      "previous": null,
     *                      "next": "https://dev.api.mardam.afaqy.co/api/v1/contractors?page=2"
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
    public function index(ContractorIndexRequest $request)
    {
        return (new ContractorListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/contractors/export/excel",
     *  tags={"Contractors"},
     *  summary="Export Contractors.",
     *  description="",
     *  operationId="export",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in  name_ar, name_en, units_count, employees, name, email, phone."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (search in name_ar, name_en, units_count, employees, name, email).", required=false
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
    public function exportExcel(ContractorIndexRequest $request)
    {
        return (new ContractorExcelReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/contractors/export/pdf",
     *  tags={"Contractors"},
     *  summary="Export Contractors as PDF file",
     *  description="",
     *  operationId="export-contractor-pdf",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in  name_ar, name_en, units_count, employees, name, email, phone."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (search in name_ar, name_en, units_count, employees, name, email).", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
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
    public function exportPdf(ContractorIndexRequest $request)
    {
        return (new ContractorPdfReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/contractors/:id",
     *  tags={"Contractors"},
     *  summary="show contractor details.",
     *  description="",
     *  operationId="contractor-show",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for contractor.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *              "id"="1",
     *              "name_ar"="مصطفى احمد",
     *              "name_en"="Mostafa Ahmed",
     *              "units_count"=50,
     *              "employees"=9,
     *              "address"="User Name",
     *              "contacts"={
     *              {
     *              "id"="1",
     *              "name"="User Name 1",
     *              "title"="manager",
     *              "phone"="123456789",
     *              "email"="user1@app.com",
     *              },
     *              {
     *              "id"="1",
     *              "name"="User Name 2",
     *              "title"="employee",
     *              "phone"="123456734",
     *              "email"="user2@app.com",
     *              },
     *            },
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
        return (new ContractorShowReport($id))->show();
    }

    /**
     * @SWG\Post(
     *  path="/v1/contractors/",
     *  tags={"Contractors"},
     *  summary="Store Contractor.",
     *  description="",
     *  operationId="contractor-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="contractor_id", type="integer", example="1"),
     *         @SWG\Property(property="name_en", type="string"),
     *         @SWG\Property(property="name_ar", type="string"),
     *         @SWG\Property(property="address", type="string"),
     *         @SWG\Property(property="commercial_number", type="integer"),
     *         @SWG\Property(property="status", type="boolean", example="true"),
     *         @SWG\Property(
     *             property="contact",
     *             type="object",
     *             @SWG\Property(property="name", type="string", example="Ahmed mohammed"),
     *             @SWG\Property(property="title", type="string", example="Manager"),
     *             @SWG\Property(property="email", type="string", example="bla@bla.com"),
     *             @SWG\Property(property="phone", type="integer", example="0512345678"),
     *         ),
     *     )
     *   ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ  المقاول بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 17
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="2003"),
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
    public function store(ContractorStoreRequest $request)
    {
        $dto = ContractorData::fromRequest($request);

        $result = (new StoreContractorAggregator($dto))->execute();

        $messages = [
            'success' => 'contractor::contractor.store-success',
            'fail'    => 'contractor::contractor.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            5000
        );
    }

    /**
     * @SWG\Put(
     *  path="/v1/contractors/:id",
     *  tags={"Contractors"},
     *  summary="Update Unit Type.",
     *  description="",
     *  operationId="Unit-type-update",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="contractor_id", type="integer", example="1"),
     *         @SWG\Property(property="name_en", type="string"),
     *         @SWG\Property(property="name_ar", type="string"),
     *         @SWG\Property(property="address", type="string"),
     *         @SWG\Property(property="commercial_number", type="integer"),
     *         @SWG\Property(property="status", type="boolean", example="true"),
     *         @SWG\Property(
     *             property="contact",
     *             type="object",
     *             @SWG\Property(property="name", type="string", example="Ahmed mohammed"),
     *             @SWG\Property(property="title", type="string", example="Manager"),
     *             @SWG\Property(property="email", type="string", example="bla@bla.com"),
     *             @SWG\Property(property="phone", type="integer", example="0512345678"),
     *         ),
     *     )
     *   ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تحديث بيانات المقاول بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="2004"),
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
    public function update(ContractorUpdateRequest $request, $id)
    {
        $dto = ContractorData::fromRequest($request, $id);

        $result = (new UpdateContractorAggregator($dto))->execute();

        $messages = [
            'success' => 'contractor::contractor.update-success',
            'fail'    => 'contractor::contractor.update-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            5001
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/contractors/:id",
     *  tags={"Contractors"},
     *  summary="Delete Contractors.",
     *  description="",
     *  operationId="Contractor-delete",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for contractor.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف المقاول بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="5002"),
     *      @SWG\Property(property="message", type="string", example="حدث خطأ أثناء الحذف, برجاء التأكد ان نوع المقاول غير مرتبط بأي مركبات او العقود و المحاولة مرة أخري."),
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
        $result = (new DeleteContractorAction($id))->execute();

        $messages = [
            'success' => 'contractor::contractor.delete-success',
        ];

        ($result == -1) ? $messages['fail'] = 'contractor::contractor.delete-failed-units-exists' :
        $messages['fail']                   = 'contractor::contractor.delete-failed';

        return $this->generateViewResponse(
            ($result == -1) ? false : $result,
            $messages,
            ($result == -1) ? 5003 : 5002
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/contractors/",
     *  tags={"Contractors"},
     *  summary="Delete many Contractors.",
     *  description="",
     *  operationId="Contractor-delete-many",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="ids[]", type="array", collectionFormat="multi", in="formData", @SWG\Items(type="integer"), description="contractors ids.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف نوع المركبة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="5002"),
     *      @SWG\Property(property="message", type="string", example="حدث خطأ أثناء الحذف, برجاء التأكد ان نوع المركبة غير مرتبط بأي مركبات و المحاولة مرة أخري."),
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
    public function destroyMany(ContractorDeleteRequest $request)
    {
        $ids = $request->input('ids');

        $result = (new DeleteContractorAction($ids))->execute();

        $messages = [
            'success' => 'contractor::contractor.delete-success',
        ];

        ($result == -1) ? $messages['fail'] = 'contractor::contractor.delete-failed-units-exists' :
        $messages['fail']                   = 'contractor::contractor.delete-failed';

        return $this->generateViewResponse(
            ($result == -1) ? false : $result,
            $messages,
            ($result == -1) ? 5003 : 5002
        );
    }

    /**
     * @SWG\Get(
     *  path="/v1/contractors/:id/units",
     *  tags={"Contractors"},
     *  summary="units for contractors.",
     *  description="",
     *  operationId="units-contractor",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for contractor.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 3,
     *          "plate_number": "bla 123"
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
    public function units(int $id, ContractorUnitRequest $request)
    {
        return (new ContractorUnitsListReport($id, $request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/contractors/companies",
     *  tags={"Contractors"},
     *  summary="list companies of contractors.",
     *  description="",
     *  operationId="contractor-companies",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *             {
     *              "machine"={
     *              "name_ar"="هدير الالات",
     *              "name_en"="Machine Talk",
     *              },
     *              "vision"={
     *              "name_ar"="رؤى",
     *              "name_en"="External Vision",
     *              },
     *              "alqimma"={
     *              "name_ar"="القمة1",
     *              "name_en"="Alqimma Co",
     *              },
     *            },
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
    public function avlCompanies()
    {
        $avls = [
            "machine" => [
                'name_ar' => "هدير الالات",
                'name_en' => "Machine Talk",
            ],
            "vision"  => [
                'name_ar' => "رؤى",
                'name_en' => "External Vision",
            ],
            "alqimma" => [
                'name_ar' => "القمة",
                'name_en' => "Alqimma Co",
            ],
        ];

        return $this->returnSuccess('', $avls);
    }
}
