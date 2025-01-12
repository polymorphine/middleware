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
    public function test_Instantiation()
    {
        $this->assertInstanceOf(MiddlewareChain::class, $this->middleware());
    }

    public function test_EmptyChain_IsProcessed()
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->process());
    }

    public function test_SingleMiddleware_IsProcessed()
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->process('single'));
        $this->assertSame(['single'], Doubles\MockedMiddleware::$processedInstances);
    }

    public function test_Chain_IsProcessedInCorrectOrder()
    {
        $response = $this->process('first', 'second', 'third');
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(['first', 'second', 'third'], Doubles\MockedMiddleware::$processedInstances);
    }

    private function process(string ...$middlewareIds): ResponseInterface
    {
        $middleware = $this->middleware(...$middlewareIds);
        return $middleware->process(new Doubles\DummyServerRequest(), new Doubles\FakeRequestHandler());
    }

    private function middleware(string ...$middlewareIds): MiddlewareInterface
    {
        Doubles\MockedMiddleware::reset();
        $middlewares = array_map(fn (string $id) => new Doubles\MockedMiddleware($id), $middlewareIds);

        return new MiddlewareChain(...$middlewares);
    }
}
