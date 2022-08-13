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

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Closure;


class LazyMiddleware implements MiddlewareInterface
{
    private Closure             $middlewareCallback;
    private MiddlewareInterface $middleware;

    /**
     * @param Closure $middlewareCallback fn() => MiddlewareInterface
     */
    public function __construct(Closure $middlewareCallback)
    {
        $this->middlewareCallback = $middlewareCallback;
    }

    /** {@inheritDoc} */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->middleware()->process($request, $handler);
    }

    private function middleware(): MiddlewareInterface
    {
        return $this->middleware ??= ($this->middlewareCallback)();
    }
}
