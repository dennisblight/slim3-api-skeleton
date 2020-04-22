<?php
namespace Core\Exceptions;

class ForbiddenException extends ResponseException
{
    protected $status = 403;

    public function __construct(string $message = 'Forbidden', array $errors = null)
    {
        parent::__construct($message, 1403, $errors);
    }
}