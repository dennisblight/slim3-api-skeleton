<?php
namespace Core\Support;

use Psr\Container\ContainerInterface;

trait Singleton
{
    protected static $instance;

    public static function getInstance()
    {
        if(is_null(static::$instance))
        {
            static::$instance = static::createInstance(Facade::getFacadeContainer());
        }

        return static::$instance;
    }

    protected static function createInstance(ContainerInterface $container)
    {
        return new static($container);
    }
}