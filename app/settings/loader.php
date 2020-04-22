<?php

use Core\Middleware\TrimSlashes;
use Core\Middleware\TrimStrings;
use Core\Middleware\ExceptionHandler;
use Tuupola\Middleware\CorsMiddleware;
use Tuupola\Middleware\JWtAuthentication;

return [
	
	'dependencies' => [
		'logger' => 'logger',
		'db' => 'database',
		'mail' => 'mail',
		ExceptionHandler::class.'::overridesDefault',
		'jwtEncode' => 'jwtEncode',
	],

	'middlewares' => [
		'validateInput',
		TrimStrings::class,
		JWtAuthentication::class => load_setting('jwt'),
		CorsMiddleware::class => load_setting('cors'),
		TrimSlashes::class,
		ExceptionHandler::class
	],

	'routes' => [
		'auth',
		'api',
	],
];