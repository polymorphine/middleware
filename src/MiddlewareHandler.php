<?php declare(strict_types=1);

/*
 * This file is part of Polymorphine/Middleware package.
 *
 * (c) Shudd3r <q3.shudder@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Polymorphine\Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;


class MiddlewareHandler implements RequestHandlerInterface
{
    private MiddlewareInterface     $middleware;
    private RequestHandlerInterface $handler;

    /**
     * Allows inserting middleware into request handler pipeline.
     */
    public function __construct(MiddlewareInterface $middleware, RequestHandlerInterface $handler)
    {
        $this->middleware = $middleware;
        $this->handler    = $handler;
    }

    /** {@inheritDoc} */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->middleware->process($request, $this->handler);
    }
}
