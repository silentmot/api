<?php

namespace Afaqy\Role\Http\Controllers;

use Afaqy\Role\DTO\RoleData;
use Illuminate\Http\Request;
use Afaqy\Role\Actions\CreateRoleAction;
use Afaqy\Role\Actions\UpdateRoleAction;
use Afaqy\Role\Actions\DeleteRolesAction;
use Afaqy\Role\Http\Reports\RolePdfReport;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Role\Http\Reports\RoleListReport;
use Afaqy\Role\Http\Reports\RoleShowReport;
use Afaqy\Role\Http\Reports\RoleExcelReport;
use Afaqy\Role\Http\Requests\RoleIndexRequst;
use Afaqy\Role\Http\Requests\RoleStoreRequest;
use Afaqy\Role\Http\Requests\RoleDeleteRequest;
use Afaqy\Role\Http\Requests\RoleUpdateRequest;
use Afaqy\Role\Http\Reports\RolePermissionsReport;
use Afaqy\Role\Http\Reports\NotificationsListReport;

class RoleController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/roles",
     *  tags={"Roles"},
     *  summary="List Clean City system roles.",
     *  description="",
     *  operationId="list",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in roles names.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="per_page", type="integer", in="query", description="The number of items per page. min 10 and max 200. default 50.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To set sorting columns (id, display_name, users_count)", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 1,
     *          "display_name": "مدير",
     *          "users_count": 5,
     *          "permissionsNames": {
     *              "إدارة جميع المستخدمين",
     *              "إدارة جميع المناطق",
     *              "إدارة جميع الوظائف"
     *          }
     *      }),
     *      @SWG\Property(property="meta", type="string", example={
     *          "currentPage": 1,
     *          "firstPage": 1,
     *          "lastPage": 1,
     *          "perPage": 15,
     *          "count": 2,
     *          "totalRecords": 2,
     *          "links": {
     *              "first": "https://dev.api.mardam.afaqy.co/api/v1/roles?page=1",
     *              "last": "https://dev.api.mardam.afaqy.co/api/v1/roles?page=1",
     *              "previous": null,
     *              "next": null
     *          }
     *      })
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
     *          "per_page"={"The per page must be at least 10."},
     *          "keyword"={"The keyword must be string."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function index(RoleIndexRequst $request)
    {
        return (new RoleListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/roles/export/excel",
     *  tags={"Roles"},
     *  summary="Export Clean City system roles.",
     *  description="",
     *  operationId="export",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in roles names.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To set sorting columns (id, display_name, users_count)", required=false
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
    public function exportExcel(RoleIndexRequst $request)
    {
        return (new RoleExcelReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/roles/export/pdf",
     *  tags={"Roles"},
     *  summary="Export Clean City system roles - PDF.",
     *  description="",
     *  operationId="exportPdf",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="To filter in roles names.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To set sorting columns (id, display_name, users_count)", required=false
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
    public function exportPdf(RoleIndexRequst $request)
    {
        return (new RolePdfReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/roles/permissions",
     *  tags={"Roles"},
     *  summary="Get Clean City system roles permissions list.",
     *  description="",
     *  operationId="role-permission-list",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *           "contract": {
     *              {
     *                  "id": 1,
     *                  "name": "read-contract",
     *                  "display_name": "عرض",
     *                  "is_selected": false
     *              },
     *              {
     *                  "id": 2,
     *                  "name": "create-contract",
     *                  "display_name": "إضافة",
     *                  "is_selected": false
     *              },
     *              {
     *                  "id": 3,
     *                  "name": "update-contract",
     *                  "display_name": "تعديل",
     *                  "is_selected": false
     *              },
     *              {
     *                  "id": 4,
     *                  "name": "delete-contract",
     *                  "display_name": "حذف",
     *                  "is_selected": false
     *              }
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
    public function permissions()
    {
        return (new RolePermissionsReport)->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/roles/:id",
     *  tags={"Roles"},
     *  summary="Show role details.",
     *  description="",
     *  operationId="show-role",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for role.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "role_name": "مدير الموق",
     *          "permissions": {
     *               "contract": {
     *                  {
     *                      "id": 1,
     *                      "name": "read-contract",
     *                      "display_name": "عرض",
     *                      "is_selected": false
     *                  },
     *                  {
     *                      "id": 2,
     *                      "name": "create-contract",
     *                      "display_name": "إضافة",
     *                      "is_selected": false
     *                  },
     *                  {
     *                      "id": 3,
     *                      "name": "update-contract",
     *                      "display_name": "تعديل",
     *                      "is_selected": false
     *                  },
     *                  {
     *                      "id": 4,
     *                      "name": "delete-contract",
     *                      "display_name": "حذف",
     *                      "is_selected": false
     *                  }
     *              },
     *          },
     *          "notifications": {1,2}
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
        return (new RoleShowReport($id))->show();
    }

    /**
     * @SWG\Post(
     *  path="/v1/roles/",
     *  tags={"Roles"},
     *  summary="Store new role in Clean City system.",
     *  description="",
     *  operationId="store-role",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="role_name", type="string", example="مدير مشروع"),
     *         @SWG\Property(property="notifications", type="array", @SWG\Items(type="integer", format="int64"), example={1,2,4}),
     *         @SWG\Property(
     *             property="permissions",
     *             type="object",
     *             @SWG\Property(property="users", type="array", @SWG\Items(type="integer", format="int64"), example={1,2,4}),
     *             @SWG\Property(property="districts", type="array", @SWG\Items(type="integer", format="int64"), example={15,62,74}),
     *         ),
     *     )
     *   ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ الوظيفة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 17
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="11001"),
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
    public function store(RoleStoreRequest $request)
    {
        $dto = RoleData::fromRequest($request);

        $result = (new CreateRoleAction($dto))->execute();

        $messages = [
            'success' => 'role::role.store-success',
            'fail'    => 'role::role.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            11001
        );
    }

    /**
     * @SWG\Put(
     *  path="/v1/roles/:id",
     *  tags={"Roles"},
     *  summary="Update roles in Clean City system.",
     *  description="",
     *  operationId="update-role",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for role.", required=true
     *  ),
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="role_name", type="string", example="مدير مشروع"),
     *         @SWG\Property(property="notifications", type="array", @SWG\Items(type="integer", format="int64"), example={1,2,4}),
     *         @SWG\Property(
     *             property="permissions",
     *             type="object",
     *             @SWG\Property(property="users", type="array", @SWG\Items(type="integer", format="int64"), example={1,2,4}),
     *             @SWG\Property(property="districts", type="array", @SWG\Items(type="integer", format="int64"), example={15,62,74}),
     *         ),
     *     )
     *   ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تحديث الوظيفة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={})
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="11002"),
     *      @SWG\Property(property="message", type="string", example="حديث خطأ أثناء التحديث, برجاء المحاولة مرة اخري."),
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
     *          "name"={"The name must be string."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function update(RoleUpdateRequest $request, int $id)
    {
        $dto = RoleData::fromRequest($request, $id);

        $result = (new UpdateRoleAction($dto))->execute();

        $messages = [
            'success' => 'role::role.update-success',
            'fail'    => 'role::role.update-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            11002
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/roles/:id",
     *  tags={"Roles"},
     *  summary="Delete role in Clean City system.",
     *  description="",
     *  operationId="delete-role",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for role.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف الوظيفة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="11003"),
     *      @SWG\Property(property="message", type="string", example="حدث خطأ أثناء الحذف, برجاء التأكد ان الوظيفة غير مرتبظ بأي مستخدمين و المحاولة مرة أخري."),
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
        $result = (new DeleteRolesAction($id))->execute();

        $messages = [
            'success' => 'role::role.delete-success',
            'fail'    => 'role::role.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            11003
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/roles/",
     *  tags={"Roles"},
     *  summary="Delete many roles in Clean City system.",
     *  description="",
     *  operationId="delete-many-role",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="ids[]", type="array", collectionFormat="multi", in="formData", @SWG\Items(type="integer"), description="roles ids.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف الوظيفة بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="11003"),
     *      @SWG\Property(property="message", type="string", example="حدث خطأ أثناء الحذف, برجاء التأكد ان الوظيفة غير مرتبظ بأي مستخدمين و المحاولة مرة أخري."),
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
     *          "ids"={"الوظيفة غير متواج."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroyMany(RoleDeleteRequest $request)
    {
        $ids = $request->input('ids');

        $result = (new DeleteRolesAction($ids))->execute();

        $messages = [
            'success' => 'role::role.delete-success',
            'fail'    => 'role::role.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            11003
        );
    }

    /**
     * @SWG\Get(
     *  path="/v1/roles/notifications",
     *  tags={"Roles"},
     *  summary="Get Clean City system roles notifications list.",
     *  description="",
     *  operationId="role-notifications-list",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          {
     *              "id": 1,
     *              "name": "الحمولة القصوي",
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
    public function notifications()
    {
        return (new NotificationsListReport)->show();
    }
}
