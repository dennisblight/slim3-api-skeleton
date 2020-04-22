<?php

namespace Core\Facades;

use Core\Support\Facade;

class Logger extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'logger';
    }
}