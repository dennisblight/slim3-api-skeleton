<?php

use Illuminate\Database\Capsule\Manager as Capsule;

return function($container) {
    $capsule = new Capsule();
    $capsule->addConnection(load_setting('database'));
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};;