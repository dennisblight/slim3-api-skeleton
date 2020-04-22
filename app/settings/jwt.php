<?php

use App\Constants\ErrorCodes;
use Core\Exceptions\UnauthorizedException;

return [
    'algorithm'  => 'RS256',
    'secret'     => [
        'private' => storage_file('keys/jwtRS256.key'),
        'public'  => storage_file('keys/jwtRS256.key.pub'),
    ],
    'header'     => 'Token',
    'regexp'     => '/(.*)/',
    'ignore'     => ['/'],
    'duration'   => '3 hours',
    'error'      => function ($response, $args) {
        throw new UnauthorizedException(
            $args['message'],
            ErrorCodes::UNAUTHORIZED_BY_JWT
        );
    },
];