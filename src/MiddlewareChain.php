<?php

/*
 * This file is part of Polymorphine/Middleware package.
 *
 * (c) Shudd3r <q3.shudder@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Polymorphine\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;


class MiddlewareChain implements MiddlewareInterface
{
    private $middlewares = [];

    public function __construct(MiddlewareInterface ...$middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->compose($handler)->handle($request);
    }

    private function compose(RequestHandlerInterface $handler): RequestHandlerInterface
    {
        $middlewares = $this->middlewares;
        while ($middleware = array_pop($middlewares)) {
            $handler = new MiddlewareHandler($middleware, $handler);
        }

        return $handler;
    }
}
