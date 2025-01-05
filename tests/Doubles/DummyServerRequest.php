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

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;


class DummyServerRequest implements ServerRequestInterface
{
    public UriInterface    $uri;
    public StreamInterface $body;

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    public function getRequestTarget(): string
    {
        return '';
    }

    public function getProtocolVersion(): string
    {
        return '1.0';
    }

    public function withProtocolVersion($version): ServerRequestInterface
    {
        return $this;
    }

    public function getHeaders(): array
    {
        return [];
    }

    public function hasHeader($name): bool
    {
        return false;
    }

    public function getHeader($name): array
    {
        return [];
    }

    public function getHeaderLine($name): string
    {
        return '';
    }

    public function withHeader($name, $value): ServerRequestInterface
    {
        return $this;
    }

    public function withAddedHeader($name, $value): ServerRequestInterface
    {
        return $this;
    }

    public function withoutHeader($name): ServerRequestInterface
    {
        return $this;
    }

    public function getBody(): StreamInterface
    {
        return $this->body;
    }

    public function withBody(StreamInterface $body): ServerRequestInterface
    {
        return $this;
    }

    public function withRequestTarget($requestTarget): ServerRequestInterface
    {
        return $this;
    }

    public function withMethod($method): ServerRequestInterface
    {
        return $this;
    }

    public function withUri(UriInterface $uri, $preserveHost = false): ServerRequestInterface
    {
        return $this;
    }

    public function getServerParams(): array
    {
        return [];
    }

    public function getCookieParams(): array
    {
        return [];
    }

    public function withCookieParams(array $cookies): ServerRequestInterface
    {
        return $this;
    }

    public function getQueryParams(): array
    {
        return [];
    }

    public function withQueryParams(array $query): ServerRequestInterface
    {
        return $this;
    }

    public function getUploadedFiles(): array
    {
        return [];
    }

    public function withUploadedFiles(array $uploadedFiles): ServerRequestInterface
    {
        return $this;
    }

    public function getParsedBody(): array
    {
        return [];
    }

    public function withParsedBody($data): ServerRequestInterface
    {
        return $this;
    }

    public function getAttributes(): array
    {
        return [];
    }

    public function getAttribute($name, $default = null)
    {
        return $default;
    }

    public function withAttribute($name, $value): ServerRequestInterface
    {
        return $this;
    }

    public function withoutAttribute($name): ServerRequestInterface
    {
        return $this;
    }
}
