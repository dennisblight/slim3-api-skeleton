<?php
namespace Core\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class TransformInput
{
    protected $fields = null;

    protected $params;

    public function __invoke(Request $request, Response $response, callable $next)
    {
        $this->params = $request->getParams($this->fields);

        $this->transformParameter();

        return $next($request->withParsedBody($this->params), $response);
    }

    protected function transformParameter()
    {
        foreach($this->params as $key => $value)
        {
            $this->params[$key] = $this->transform($value);
        }
    }

    abstract protected function transform($value);
}