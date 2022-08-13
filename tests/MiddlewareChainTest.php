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
use Polymorphine\Middleware\MiddlewareChain;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;


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
        $this->assertInstanceOf(ResponseInterface::class, $this->process(new Doubles\MockedMiddleware('single')));
        $this->assertSame(['single'], Fixtures\ExecutionOrder::$processIdList);
    }

    public function testChainIsProcessedInCorrectOrder()
    {
        $response = $this->process(
            new Doubles\MockedMiddleware('first'),
            new Doubles\MockedMiddleware('second'),
            new Doubles\MockedMiddleware('third')
        );
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(['first', 'second', 'third'], Fixtures\ExecutionOrder::$processIdList);
    }

    private function process(MiddlewareInterface ...$middlewares): ResponseInterface
    {
        $middleware = $this->middleware(...$middlewares);
        return $middleware->process(new Doubles\DummyServerRequest(), new Doubles\FakeRequestHandler());
    }

    private function middleware(MiddlewareInterface ...$middlewares): MiddlewareInterface
    {
        Fixtures\ExecutionOrder::reset();
        return new MiddlewareChain(...$middlewares);
    }
}
