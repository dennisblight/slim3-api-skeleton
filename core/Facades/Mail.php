<?php

namespace Core\Facades;

use Core\Support\Facade;

class Mail extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mail';
    }
}