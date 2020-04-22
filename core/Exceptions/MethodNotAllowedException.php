<?php
namespace Core\Exceptions;

class MethodNotAllowedException extends ResponseException
{
    protected $status = 405;
    private $allowedMethods;

    public function __construct(array $allowedMethods = null)
    {
        parent::__construct('Method Not Allowed', 1405);
        $this->allowedMethods = $allowedMethods;
    }

    public function getResponseData()
    {
        $data = parent::getResponseData();
        if(!empty($this->allowedMethods))
        {
            $data['allowedMethods'] = $this->allowedMethods;
        }
        return $data;
    }
}