<?php

namespace Afaqy\TripWorkflow\Helpers;

trait PrepareEventsRequest
{
    /**
     * @param  mixed $request
     * @return array
     */
    public function getRequest($request): array
    {
        if (is_object($request)) {
            return [
                'url'     => $request->fullUrl(),
                'method'  => $request->method(),
                'headers' => $request->header(),
                'body'    => $request->all(),
            ];
        }

        return (array) $request;
    }

    /**
     * @param  mixed $response
     * @return array
     */
    public function getResponse($response): array
    {
        if (is_object($response)) {
            return [
                'headers' => $response->getHeaders(),
                'status'  => $response->getStatusCode(),
                'body'    => json_decode($response->getBody()->getContents(), true),
            ];
        }

        return (array) $response;
    }

    /**
     * @param  mixed $exception
     * @return array
     */
    public function getException($exception): array
    {
        return [
            'error_code'    => $exception->getCode(),
            'error_message' => $exception->getMessage(),
            'error_file'    => $exception->getFile(),
            'error_line'    => $exception->getLine(),
        ];
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags()
    {
        return ['logs', (new \ReflectionClass($this))->getShortName()];
    }
}
