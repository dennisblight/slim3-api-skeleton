<?php
namespace Core\Exceptions;

class BadRequestException extends ResponseException
{
    protected $status = 400;

    public function __construct(string $message = 'Bad Request', int $code = 1400)
    {
        parent::__construct($message, $code);
    }
}