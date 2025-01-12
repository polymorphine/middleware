<?php declare(strict_types=1);

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


class MockedMiddleware implements MiddlewareInterface
{
    public static bool  $instance = false;
    public static array $processedInstances = [];

    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
        self::$instance = true;
    }

    public static function reset(): void
    {
        self::$instance           = false;
        self::$processedInstances = [];
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        self::$processedInstances[] = $this->id;
        return $handler->handle($request);
    }
}
