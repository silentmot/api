<?php

namespace Afaqy\Core\Helpers;

class Tracer
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var int|null
     */
    protected $error_code = null;

    /**
     * @var string
     */
    protected $error_message = 'Operation failed!';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $success_message = 'Success operation';

    /**
     * @param array $errors
     * @return void
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param string $message
     * @return void
     */
    public function setErrorMessage(string $message)
    {
        $this->error_message = $message;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * @param int $code
     * @return void
     */
    public function setErrorCode(int $code)
    {
        $this->error_code = $code;
    }

    /**
     * @return int|null
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * @param string $message
     * @return void
     */
    public function setSuccessMessage(string $message)
    {
        $this->success_message = $message;
    }

    /**
     * @return string
     */
    public function getSuccessMessage()
    {
        return $this->success_message;
    }

    /**
     * @param array $message
     * @return void
     */
    public function setSuccessData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getSuccessData()
    {
        return $this->data;
    }
}
