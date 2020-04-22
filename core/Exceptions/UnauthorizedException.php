<?php
namespace Core\Exceptions;

class UnauthorizedException extends ResponseException
{
    protected $status = 401;

    public function __construct(string $message = 'Unauthorized', $code = 1401)
    {
        parent::__construct($message, $code);
    }
}