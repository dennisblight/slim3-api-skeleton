<?php
namespace Core\Exceptions;

class ResponseException extends \Exception
{
    protected $status;
    protected $errors;

    public function __construct(string $message = null, int $code = null, array $errors = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    public function getResponseData()
    {
        $data = [
            'code' => $this->code,
            'message' => $this->message,
        ];

        if(!empty($this->errors))
            $data['errors'] = $this->errors;

        return $data;
    }
}