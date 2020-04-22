<?php
namespace App\Controllers;

use Slim\Http\Body;
use Slim\Http\Stream;
use App\Utilities\Parser;
use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function plainToken($request, $response)
    {
        $token = $this['jwtEncode']();
        return $response->withJson(Parser::parse(['token' => $token]));
    }

    public function publicKey($request, $response)
    {
        $stream = \read_file_stream(storage_path('keys/jwtRS256.key.pub'));
        return $response->withHeader('Content-Type', 'text/plain')
            ->withBody($stream);
    }

    public function login($request, $response)
    {
        $email = $request->getParam('email');
        $password = $request->getParam('password');

        $token = $this['jwtEncode']();

        return $response->withJson(Parse::parse(['token' => $token]));
    }

    public function refreshToken($request, $response)
    {
        $credential = $request->getAttribute('token');

        $token = $this['jwtEncode']();

        return $response->withJson(Parse::parse(['token' => $token]));
    }

    public function currentUser($request, $response)
    {
        $credential = $request->getAttribute('token');

        return $response->withJson(Parser::parse());
    }

    public function register($request, $response)
    {
        return $response->withJson(Parser::parse());
    }

    public function registerResendVerification($request, $response)
    {
        $email = $request->getParam('email');

        return $response->withJson(Parser::parse());
    }

    public function restorePassword($request, $response)
    {
        $email = $request->getParam('email');

        return $response->withJson(Parser::parse());
    }

    public function restorePasswordConfirm($request, $response)
    {
        $token = $request->getParam('token');
        $password = $request->getParam('password');

        return $response->withJson(Parser::parse());
    }
}