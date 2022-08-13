<?php declare(strict_types=1);

/*
 * This file is part of Polymorphine/Middleware package.
 *
 * (c) Shudd3r <q3.shudder@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Polymorphine\Middleware\Tests;

use PHPUnit\Framework\TestCase;
use Polymorphine\Middleware\LazyMiddleware;
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
        $this->assertFalse(Doubles\MockedMiddleware::$instance);
        $middleware->process(new Doubles\DummyServerRequest(), new Doubles\FakeRequestHandler());
        $this->assertTrue(Doubles\MockedMiddleware::$instance);
    }

    private function middleware(): MiddlewareInterface
    {
        Doubles\MockedMiddleware::$instance = false;
        return new LazyMiddleware(function () {
            return new Doubles\MockedMiddleware('lazy');
        });
    }
}
