<?php
namespace Core\Exceptions;

class ServerErrorException extends ResponseException
{
    protected $status = 500;

    public function __construct(string $message = 'Server Error', int $code = 2500)
    {
        parent::__construct($message, $code);
    }
}