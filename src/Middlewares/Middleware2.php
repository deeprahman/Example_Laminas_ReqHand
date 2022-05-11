<?php

namespace Api\Middlewares;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Laminas\Diactoros\Response\TextResponse;

class Middleware2 implements MiddlewareInterface
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
        if(($request->getAttribute('next')) !== '1'){
            return $handler->handle($request);
        }
        
        return new TextResponse('Inside Middleware 2'); 
    }
}