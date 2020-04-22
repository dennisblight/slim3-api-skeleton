<?php
namespace Core\Middleware;

use Core\Exceptions\NotFoundException;
use Core\Exceptions\MethodNotAllowedException;
use Core\Exceptions\ResponseException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ExceptionHandler
{
    public static function overridesDefault($container)
    {
        $container['notAllowedHandler'] = function($c) {
            return function ($request, $response, $allowedMethods) {
                throw new MethodNotAllowedException($allowedMethods);
            };
        };

        $container['notFoundHandler'] = function($c) {
            return function ($request, $response) {
                throw new NotFoundException();
            };
        };
    }

    public function __invoke(Request $request, Response $response, callable $next)
    {
        try
        {
            return $next($request, $response);
        }
        catch(ResponseException $ex)
        {
            return $response
                ->withStatus($ex->getStatus())
                ->withJson($ex->getResponseData());
        }
    }
}