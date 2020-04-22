<?php

use Monolog\Logger;
use Monolog\Handler\FirePHPHandler;
use Monolog\Processor\WebProcessor;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Processor\IntrospectionProcessor;

return function ($container) {

    $logger = new Logger('SLIM');
    
    $handler = new RotatingFileHandler(storage_path('logs/debug.log'));
    $handler->setFormatter(new JsonFormatter());
    
    $logger->pushHandler($handler);
    $logger->pushProcessor(new IntrospectionProcessor());
    $logger->pushProcessor(new WebProcessor());
    
    return $logger;
};