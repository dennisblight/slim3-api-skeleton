<?php
namespace Core\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class ValidationMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $route = $request->getAttribute('route');

        if(isset($route))
        {
            $routeCallable = $route->getCallable();
            if(is_string($routeCallable))
            {
                [$ruleClass, $ruleMethod] = $this->getRuleClass($routeCallable);
    
                $rule = new $ruleClass();
                
                if(method_exists($rule, $ruleMethod))
                {
                    $rule->$ruleMethod($request);
                    // $validator = isset($ruleMethod) ? $rule->$ruleMethod($request) : $rule($request);
                    // if(isset($validator) && !$validator->validate())
                    // {
                    //     throw new ForbiddenException('Invalid input', 1001, $validator->errors());
                    // }
                }
            }
        }

        return $next($request, $response);
    }

    protected function getRuleClass(string $routeCallable): string
    {
        $ruleClass = str_replace('Controller', 'Validation', $routeCallable);
                
        if(strpos($ruleClass, ':') !== false)
        {
            [$ruleClass, $ruleMethod] = explode(':', $ruleClass);
        }

        return [$ruleClass, $ruleMethod ?? '__invoke'];
    }
}