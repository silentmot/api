<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Str;
use Afaqy\Core\Http\Responses\ResponseBuilder;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Afaqy\TripWorkflow\Events\Failure\WorkFlowInternalServerError;

class Handler extends ExceptionHandler
{
    use ResponseBuilder;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (Str::contains($exception->getFile(), 'TripWorkflow')) {
            event(new WorkFlowInternalServerError(resolve('ID'), $request, $exception));
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->returnError(404, trans('messages.exception.404.model'));
        } elseif ($exception instanceof NotFoundHttpException) {
            return $this->returnError(404, trans('messages.exception.404.http'));
        } elseif ($exception instanceof PostTooLargeException) {
            return $this->returnError(413, trans('messages.exception.413'));
        } elseif ($exception instanceof HttpException && $exception->getStatusCode() == '403') {
            return $this->returnError(403, trans('messages.exception.403'));
        }

        return parent::render($request, $exception);
    }
}
