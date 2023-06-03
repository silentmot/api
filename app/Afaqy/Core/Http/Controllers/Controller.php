<?php

namespace Afaqy\Core\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Afaqy\Core\Http\Responses\ResponseBuilder;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use DispatchesJobs;
    use ResponseBuilder;
    use ValidatesRequests;
    use AuthorizesRequests;

    /**
     * @SWG\Swagger(
     *     basePath="/api",
     *     host=L5_SWAGGER_CONST_HOST,
     *     @SWG\Info(
     *         version="2.0.0",
     *         title="Clean City API Documentation",
     *         description="",
     *         @SWG\Contact(
     *             email="info@afaqy.com"
     *         ),
     *     )
     * )
     */

    /**
     * @OA\SecurityScheme(
     *     type="oauth2",
     *     description="Use a global client_id / client_secret and your username / password combo to obtain a token",
     *     name="Password Based",
     *     in="header",
     *     scheme="https",
     *     securityScheme="Password Based",
     *     @OA\Flow(
     *         flow="password",
     *         authorizationUrl="/oauth/authorize",
     *         tokenUrl="/oauth/token",
     *         refreshUrl="/oauth/token/refresh",
     *         scopes={}
     *     )
     * )
     */

    /**
     * @SWG\Tag(
     *   name="Auth",
     *   description="Operations about Authentication",
     * ),
     * @SWG\Tag(
     *   name="Users",
     *   description="Operations about Users",
     * ),
     * @SWG\Tag(
     *   name="Roles",
     *   description="Operations about Roles",
     * ),
     * @SWG\Tag(
     *   name="Districts",
     *   description="Operations about Districts",
     * ),
     * @SWG\Tag(
     *   name="Scales",
     *   description="Operations about Scales",
     * ),
     * @SWG\Tag(
     *   name="Gates",
     *   description="Operations about Gates",
     * ),
     * @SWG\Tag(
     *   name="Zones",
     *   description="Operations about Zones",
     * ),
     * @SWG\Tag(
     *   name="WasteTypes",
     *   description="Operations about Waste Types",
     * ),
     * @SWG\Tag(
     *   name="UnitTypes",
     *   description="Operations about Unit Types",
     * ),
     * @SWG\Tag(
     *   name="Units",
     *   description="Operations about Unit",
     * ),
     * @SWG\Tag(
     *   name="Contracts",
     *   description="Operations about Contract",
     * ),
     * @SWG\Tag(
     *   name="Permissions",
     *   description="Operations about permission",
     * ),
     */

    /**
     * Generate view show item from the given query
     *
     * @param  mixed  $result
     * @param  array $message_keys
     * @param  int|null $error_code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function generateViewResponse($result, array $message_keys, ? int $error_code = null) : JsonResponse
    {
        if (is_object($result)) {
            if ($result->id ?? false) {
                return $this->returnSuccess(trans($message_keys['success']), ['id' => $result->id]);
            }

            return $this->returnBadRequest($error_code, trans($message_keys['fail']));
        }

        if ($result) {
            return $this->returnSuccess(trans($message_keys['success']));
        }

        return $this->returnBadRequest($error_code, trans($message_keys['fail']));
    }
}
