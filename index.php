<?php
define('BASEPATH', __DIR__);

require_once BASEPATH.'/vendor/autoload.php';
require_once BASEPATH.'/core/Bootstraper.php';

$bootstraper = new \Core\Bootstraper();
$bootstraper->boot();
$bootstraper->runApp();