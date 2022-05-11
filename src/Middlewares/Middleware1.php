<?php

namespace Api\Middlewares;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Laminas\Diactoros\Response\TextResponse;

class Middleware1 implements MiddlewareInterface
{
    /**
     * Instance of the ResponseInterface
     *
     * @var ResponseInterface
     */
    protected $res;

    public function __construct(ResponseInterface $response)
    {
        $this->res = $response;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $req= $request->withAttribute('next', '1');
        // throw new \RuntimeException('Exception thrown !');
        if(1){
            return $handler->handle($req);
        }
        return $this->res; 
    }
}