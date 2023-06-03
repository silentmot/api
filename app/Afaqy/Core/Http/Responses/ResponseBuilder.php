<?php

namespace Afaqy\Core\Http\Responses;

use Illuminate\Http\JsonResponse;
use ArrayKeysCaseTransform\ArrayKeys;

trait ResponseBuilder
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var string|null
     */
    private $response_message = '';

    /**
     * @var int|null
     */
    private $internal_code;

    /**
     * @var \Exception
     */
    private $exception;

    /**
     * Return success response.
     *
     * @param  string   $message
     * @param  array    $data
     * @param  int  $headerCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnSuccess(string $message = 'ok', array $data = [], int $headerCode = 200): JsonResponse
    {
        return $this->setResponseMessage($message)
            ->setData($data)
            ->success($headerCode);
    }

    /**
     * Return error response.
     *
     * @param  int      $headerCode
     * @param  string|null  $message
     * @param  array        $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnError(int $headerCode, ?string $message = '', array $data = []): JsonResponse
    {
        return $this->setResponseMessage($message)
            ->setData($data)
            ->error($headerCode);
    }

    /**
     * Return bad request response.
     *
     * @param  int|null  $internalCode
     * @param  string|null   $message
     * @param  array         $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnBadRequest(?int $internalCode = null, ?string $message = '', array $data = []): JsonResponse
    {
        return $this->setInternalCode($internalCode)
            ->setResponseMessage($message)
            ->setData($data)
            ->error(400);
    }

    /**
     * Set the given exception.
     *
     * @param  \Exception  $exception
     * @return $this
     */
    public function setException(\Exception $exception): self
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * Set internal error codes.
     *
     * @param  int|null  $code
     * @return $this
     */
    protected function setInternalCode(?int $code): self
    {
        $this->internal_code = $code;

        return $this;
    }

    /**
     * Set response message.
     *
     * @param  string|null  $message
     * @return $this
     */
    protected function setResponseMessage(?string $message): self
    {
        $this->response_message = $message;

        return $this;
    }

    /**
     * Set response data.
     *
     * @param  array  $data
     * @return $this
     */
    protected function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get response exception.
     *
     * @return \Exception|null
     */
    public function getException(): ?\Exception
    {
        return $this->exception;
    }

    /**
     * Get formated exception data.
     *
     * @return array
     */
    protected function responseDebug(): array
    {
        return [
            'exceptionMessage' => $this->exception->getMessage(),
            'exceptionFile'    => $this->exception->getFile(),
            'exceptionLine'    => $this->exception->getLine(),
        ];
    }

    /**
     * Get internal error codes.
     *
     * @return int|null
     */
    protected function getInternalCode(): ?int
    {
        return $this->internal_code;
    }

    /**
     * Get response message.
     *
     * @return  string|null
     */
    protected function getResponseMessage(): ?string
    {
        return $this->response_message;
    }

    /**
     * Get response data.
     *
     * @return array
     */
    protected function getData(): array
    {
        return $this->data;
    }

    /**
     * Build error response.
     *
     * @param  int  $headerCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(int $headerCode): JsonResponse
    {
        $response = [];

        if (!empty($this->getInternalCode())) {
            $response['code'] = $this->getInternalCode();
        }

        $response['message'] = $this->getResponseMessage();

        $response['errors'] = $this->getData();

        if (config('app.debug') == true && !empty($this->getException())) {
            $response['debug'] = $this->responseDebug();
        }

        return $this->response($response, $headerCode);
    }

    /**
     * Build success response.
     *
     * @param  int  $headerCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success(int $headerCode): JsonResponse
    {
        $response = [
            'message'=> $this->getResponseMessage(),
            'data'   => $this->getData(),
        ];

        if (isset($this->getData()['data'])) {
            $response['data'] = $this->getData()['data'];
        }

        if (isset($this->getData()['additionalInformation'])) {
            $response['additionalInformation'] = $this->getData()['additionalInformation'];
        }

        if (isset($this->getData()['meta'])) {
            $response['meta'] = $this->getData()['meta'];
        }

        return $this->response($response, $headerCode);
    }

    /**
     * Prepare returned response.
     *
     * @param  array    $response
     * @param  int  $headerCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function response(array $response, int $headerCode): JsonResponse
    {
        return response()->json(ArrayKeys::toSnakeCase($response), $headerCode);
    }
}
