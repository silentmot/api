<?php

namespace Afaqy\Core\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Afaqy\Core\Http\Responses\ResponseBuilder;

class BaseException extends Exception
{
    use ResponseBuilder;

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        Log::error($this);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return $this->setException($this)->returnBadRequest($this->getInternalCode(), $this->getMessage());
    }
}
