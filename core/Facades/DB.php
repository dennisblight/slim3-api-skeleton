<?php

namespace Core\Facades;

use Core\Support\Facade;

class DB extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'db';
    }
}