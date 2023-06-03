<?php

namespace Afaqy\User\Http\Controllers;

use Afaqy\User\Models\User;
use Afaqy\User\DTO\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Afaqy\User\Actions\StoreUserAction;
use Afaqy\User\Actions\DeleteUserAction;
use Afaqy\User\Actions\UserUpdateAction;
use Afaqy\User\Http\Reports\UserPdfReport;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\User\Http\Reports\UserListReport;
use Afaqy\User\Http\Reports\UserShowReport;
use Afaqy\User\Http\Reports\UserExcelReport;
use Afaqy\User\Http\Requests\UserIndexRequest;
use Afaqy\User\Http\Requests\UserStoreRequest;
use Afaqy\User\Http\Requests\UserDeleteRequest;
use Afaqy\User\Http\Requests\UserUpdateRequest;
use Afaqy\User\Http\Reports\UserPermissionsReport;
use Afaqy\User\Http\Reports\UserShowProfileReport;
use Afaqy\User\Http\Requests\UpdateUserProfileRequest;
use Afaqy\User\Actions\Aggregators\UpdateUserProfileAggregator;

class UserController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/users",
     *  tags={"Users"},
     *  summary="Get Clean City system users.",
     *  description="",
     *  operationId="UsersList",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in username, name, email, role name."
     *  ),
     *  @SWG\Parameter(
     *      name="per_page", type="integer", in="query", description="The number of items per page. min 10 and max 200. default 50.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (full_name, email or role).", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="direction", type="string", in="query", description="The direction of sorting. value maybe (asc or desc). default desc.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          {
     *              "id"="1",
     *              "name"="User Name",
     *              "username"="user-name",
     *              "email"="user@app.com",
     *              "phone"="123456789",
     *              "photo"="https://dev.api.mardam.afaqy.co/images/users/photo.png",
     *              "role"="designer",
     *          },
     *          {
     *              "id"="2",
     *              "name"="User Name",
     *              "username"="user-name",
     *              "email"="user@app.com",
     *              "phone"="123456789",
     *              "photo"="https://dev.api.mardam.afaqy.co/images/users/photo.png",
     *              "role"="designer",
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
     *                      "first": "https://dev.api.mardam.afaqy.co/api/v1/users?page=1",
     *                      "last": "https://dev.api.mardam.afaqy.co/api/v1/users?page=2",
     *                      "previous": null,
     *                      "next": "https://dev.api.mardam.afaqy.co/api/v1/users?page=2"
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
    public function index(UserIndexRequest $request)
    {
        return (new UserListReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/users/export/excel",
     *  tags={"Users"},
     *  summary="Export Clean City system users.",
     *  description="",
     *  operationId="export",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in username, name, email, role name."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (full_name, email or role).", required=false
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
    public function exportExcel(UserIndexRequest $request)
    {
        return (new UserExcelReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/users/export/pdf",
     *  tags={"Users"},
     *  summary="Export Clean City system users - PDFs.",
     *  description="",
     *  operationId="exportPdf",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="keyword", type="string", in="query", description="search in username, name, email, role name."
     *  ),
     *  @SWG\Parameter(
     *      name="sort", type="string", in="query", description="To sort by (full_name, email or role).", required=false
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
    public function exportPdf(UserIndexRequest $request)
    {
        return (new UserPdfReport($request))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/users/profile",
     *  tags={"Users"},
     *  summary="Get current looged in user.",
     *  description="",
     *  operationId="GetLoggedInUser",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "id"="1",
     *          "name"="User Name",
     *          "username"="user-name",
     *          "email"="user@app.com",
     *          "phone"="123456789",
     *          "photo"="https://dev.api.mardam.afaqy.co/images/users/photo.png",
     *          "role"="employee",
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
    public function showProfile()
    {
        $id = Auth::id();

        return (new UserShowProfileReport($id))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/users/permissions",
     *  tags={"Users"},
     *  summary="Get current logged in user permissions.",
     *  description="",
     *  operationId="GetLoggedInUserPermissions",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "contract": {
     *              {
     *                  "id": 1,
     *                  "name": "read-contract",
     *                  "display_name": "عرض",
     *                  "is_selected": true
     *              },
     *              {
     *                  "id": 2,
     *                  "name": "create-contract",
     *                  "display_name": "إضافة",
     *                  "is_selected": false
     *              }
     *          },
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function getPermissions()
    {
        $id = Auth::id();

        return (new UserPermissionsReport($id))->show();
    }

    /**
     * @SWG\Get(
     *  path="/v1/users/:id",
     *  tags={"Users"},
     *  summary="Show user information for the given id.",
     *  description="",
     *  operationId="user-show",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="Id for user.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "id"="1",
     *          "first_name"="User Name",
     *          "last_name"="User Name",
     *          "username"="user-name",
     *          "email"="user@app.com",
     *          "phone"="123456789",
     *          "role"="employee",
     *          "status"=1,
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
        return (new UserShowReport($id))->show();
    }

    /**
     * @SWG\Put(
     *  path="/v1/users/profile",
     *  tags={"Users"},
     *  summary="Handle updating user profile.",
     *  description="",
     *  operationId="UpdateUserProfile",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  consumes={"application/x-www-form-urlencoded"},
     *  produces={"application/json"},
     *  @SWG\Parameter(
     *      name="old_password", type="string", in="formData", description="The password old.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="password", type="string", in="formData", description="The password of the user.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="password_confirmation", type="string", in="formData", description="The password confirmation.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="phone", type="string", in="formData", description="user phone.", required=false
     *  ),
     *  @SWG\Parameter(
     *      name="avatar", type="file", in="formData", description="The photo.", required=false
     *  ),
     *  @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="The User Profile updated successfully."),
     *      @SWG\Property(property="data", type="string", example={})
     *  )),
     *  @SWG\Response(response=400, description="Unprocessable Entity", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="3001"),
     *      @SWG\Property(property="message", type="string", example="Failed to update user."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=404, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Document or file requested by the client was not found."),
     *      @SWG\Property(property="errors", type="object", example={
     *      })
     *  )),
     *  @SWG\Response(response=422, description="Unprocessable Entity", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="The given data was invalid."),
     *      @SWG\Property(property="errors", type="string", example={
     *          "email"={"The email must be a valid email address."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $data = UserData::fromRequest($request, Auth::id(), true);

        $result = (new UpdateUserProfileAggregator($data))->execute();

        $messages = [
            'success' => 'user::users.update-profile-success',
            'fail'    => 'user::users.update-profile-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            '1004'
        );
    }

    /**
     * @SWG\Post(
     *  path="/v1/users/",
     *  tags={"Users"},
     *  summary="Store user in Clean City system.",
     *  description="",
     *  operationId="user-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="first_name", type="string", in="formData", description="The First name of the user.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="last_name", type="string", in="formData", description="The Last name of the user.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="username", type="string", in="formData", description="The Username.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="phone", type="string", in="formData", description="user phone.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="email", type="string", in="formData", description="user email.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="password", type="string", in="formData", description="The password.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="role", type="integer", in="formData", description="role of users.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="status", type="boolean", in="formData", description="The user Status.", required=true,
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ المستخدم بنجاح"),
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
    public function store(UserStoreRequest $request)
    {
        $dto = UserData::fromRequest($request);

        $result = (new StoreUserAction($dto))->execute();

        $messages = [
            'success' => 'user::users.create-success',
            'fail'    => 'user::users.create-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            2004
        );
    }

    /**
     * @SWG\Put(
     *  path="/v1/users/:id",
     *  tags={"Users"},
     *  summary="Update user for the given id.",
     *  description="",
     *  operationId="users-update",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="unit id.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="first_name", type="string", in="formData", description="The First name of the user.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="last_name", type="string", in="formData", description="The Last name of the user.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="username", type="string", in="formData", description="The Username.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="phone", type="string", in="formData", description="user phone.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="email", type="string", in="formData", description="user email.", required=true
     *  ),
     *  @SWG\Parameter(
     *      name="role", type="integer", in="formData", description="role of users.", required=true,
     *  ),
     *  @SWG\Parameter(
     *      name="status", type="boolean", in="formData", description="The user Status.", required=true,
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم تعديل المستخدم بنجاح"),
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
    public function update(UserUpdateRequest $request, int $id)
    {
        $dto = UserData::fromRequest($request, $id);

        $result = (new UserUpdateAction($dto))->execute();

        $messages = [
            'success' => 'user::users.update-success',
            'fail'    => 'user::users.update-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            2002
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/users/:id",
     *  tags={"Users"},
     *  summary="Delete user from Clean City system.",
     *  description="",
     *  operationId="users-delete",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="id", type="string", in="query", description="user id", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حذف المستخدم بنجاح"),
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
     *  @SWG\Response(response=404, description="Not Found", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Document or file requested by the client was not found."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroy(int $id)
    {
        $result = (new DeleteUserAction($id))->execute();

        $messages = [
            'success' => 'user::users.delete-success',
            'fail'    => 'user::users.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            2005
        );
    }

    /**
     * @SWG\Delete(
     *  path="/v1/users/",
     *  tags={"Users"},
     *  summary="Delete many users from Clean City system.",
     *  description="",
     *  operationId="users-delete-many",
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
     *  @SWG\Response(response=422, description="Unprocessable Entity", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="The given data was invalid."),
     *      @SWG\Property(property="errors", type="string", example={
     *          "ids"={"المركحبة غير متواج."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroyMany(UserDeleteRequest $request)
    {
        $result = (new DeleteUserAction($request->ids))->execute();

        $messages = [
            'success' => 'user::users.delete-multi-success',
            'fail'    => 'user::users.delete-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            2005
        );
    }
}
