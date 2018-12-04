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
use Polymorphine\Middleware\Tests\Doubles\FakeRequestHandler;
use Polymorphine\Middleware\Tests\Doubles\DummyServerRequest;
use Polymorphine\Middleware\Tests\Doubles\MockedMiddleware;
use Polymorphine\Middleware\Tests\Fixtures\ExecutionOrder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;


class MiddlewareChainTest extends TestCase
{
    public function testInstantiation()
    {
        $this->assertInstanceOf(MiddlewareChain::class, $this->middleware());
    }

    public function testEmptyChainIsProcessed()
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->process());
    }

    public function testSingleMiddlewareIsProcessed()
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->process(new MockedMiddleware('single')));
        $this->assertSame(['single'], ExecutionOrder::$processIdList);
    }

    public function testChainIsProcessedInCorrectOrder()
    {
        $response = $this->process(
            new MockedMiddleware('first'),
            new MockedMiddleware('second'),
            new MockedMiddleware('third')
        );
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(['first', 'second', 'third'], ExecutionOrder::$processIdList);
    }

    private function process(MiddlewareInterface ...$middlewares): ResponseInterface
    {
        $middleware = $this->middleware(...$middlewares);
        return $middleware->process(new DummyServerRequest(), new FakeRequestHandler());
    }

    private function middleware(MiddlewareInterface ...$middlewares)
    {
        ExecutionOrder::reset();
        return new MiddlewareChain(...$middlewares);
    }
}
