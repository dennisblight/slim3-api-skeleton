<?php

namespace Core\Facades;

use Core\Support\Facade;

class Router extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'router';
    }
}