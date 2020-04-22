<?php
namespace Core\Exceptions;

class NotFoundException extends ResponseException
{
    protected $status = 404;

    public function __construct()
    {
        parent::__construct('Not Found', 1404);
    }
}