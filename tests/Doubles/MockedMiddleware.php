<?php

/*
 * This file is part of Polymorphine/Middleware package.
 *
 * (c) Shudd3r <q3.shudder@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Polymorphine\Middleware\Tests\Doubles;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Polymorphine\Middleware\Tests\Fixtures\ExecutionOrder;


class MockedMiddleware implements MiddlewareInterface
{
    public static $instance = false;

    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
        self::$instance = true;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        ExecutionOrder::add($this->id);
        return $handler->handle($request);
    }
}
