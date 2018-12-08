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

use PHPUnit\Framework\TestCase;
use Polymorphine\Middleware\Tests\Doubles\DummyServerRequest;
use Polymorphine\Middleware\Tests\Doubles\FakeRequestHandler;
use Polymorphine\Middleware\Tests\Doubles\MockedMiddleware;
use Psr\Http\Server\MiddlewareInterface;


class LazyMiddlewareTest extends TestCase
{
    public function testInstantiation()
    {
        $this->assertInstanceOf(MiddlewareInterface::class, $this->middleware());
    }

    public function testInvokingMiddleware()
    {
        $middleware = $this->middleware();
        $this->assertFalse(MockedMiddleware::$instance);
        $middleware->process(new DummyServerRequest(), new FakeRequestHandler());
        $this->assertTrue(MockedMiddleware::$instance);
    }

    private function middleware()
    {
        MockedMiddleware::$instance = false;
        return new LazyMiddleware(function () {
            return new MockedMiddleware('lazy');
        });
    }
}
