<?php

// In public/index.php:
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\MiddlewarePipe;


use function Laminas\Stratigility\middleware;
use function Laminas\Stratigility\path;

use Api\Middlewares\Middleware1;
use Api\Middlewares\Middleware2;

$mdlr1 = new Middleware1((new ResponseFactory())->createResponse());
$mdlr2 = new Middleware2((new ResponseFactory())->createResponse());

$app = new MiddlewarePipe();

// Landing page
$app->pipe($mdlr1);
$app->pipe($mdlr2);

// 404 handler
$app->pipe(new NotFoundHandler(function () {
    return new Response();
}));

$server = new RequestHandlerRunner(
    $app,
    new SapiEmitter(),
    static function () {
        return ServerRequestFactory::fromGlobals();
    },
    static function (\Throwable $e) {
        xdebug_break();
        $response = (new ResponseFactory())->createResponse(500)->withBody(
            (new StreamFactory())->createStream($e->getMessage())
        );
        $response->getBody()->write(sprintf(
            'An error occurred: %s',
            $e->getMessage
        ));
        return $response;
    }
);

$server->run();