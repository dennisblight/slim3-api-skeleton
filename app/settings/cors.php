<?php

use Core\Facades\Router;
use FastRoute\Dispatcher;
use App\Constants\ErrorCodes;
use Core\Exceptions\UnauthorizedException;

return [
    'origin' => [
        'http://example.com',
        'http://www.example.com',
        'https://example.com',
        'https://www.example.com',
    ],
    'credentials' => true,
    'headers.allow' => [
        'Authorization', 'Token'
    ],
    // 'methods' => ['GET', 'POST'],
    'methods' => function($request) {
        $dispatch = Router::dispatch($request);
        if (Dispatcher::METHOD_NOT_ALLOWED === $dispatch[0]) {
            return $dispatch[1];
        }
    },
    'error' => function ($request, $response, $args) {
        throw new UnauthorizedException(
            $args['message'],
            ErrorCodes::UNAUTHORIZED_BY_CORS
        );
    }
];