<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use InvalidArgumentException;
use Nyholm\Psr7\{
    Uri,
    Request,
    Response,
    ServerRequest,
};
use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    HttpMessageConverter,
    TransformerException,
    Type,
};
use Phrity\Util\Transformer\Test\TestHttpMessage;

/**
 * Transformer test class.
 */
class HttpMessageConverterTest extends TestCase
{
    public function testUriConverter(): void
    {
        $transformer = new HttpMessageConverter();
        $subject = new Uri('https://user:pwd@example.com:1234/path/to/file?q1=1#f1');

        $this->assertEquals((object)[
            'scheme' => 'https',
            'authority' => 'user:pwd@example.com:1234',
            'userInfo' => 'user:pwd',
            'host' => 'example.com',
            'port' => 1234,
            'path' => '/path/to/file',
            'query' => 'q1=1',
            'fragment' => 'f1',
        ], $transformer->transform($subject));
        $this->assertEquals([
            'scheme' => 'https',
            'authority' => 'user:pwd@example.com:1234',
            'userInfo' => 'user:pwd',
            'host' => 'example.com',
            'port' => 1234,
            'path' => '/path/to/file',
            'query' => 'q1=1',
            'fragment' => 'f1',
        ], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(
            'https://user:pwd@example.com:1234/path/to/file?q1=1#f1',
            $transformer->transform($subject, Type::STRING)
        );
        $this->assertFalse($transformer->canTransform($subject, Type::INTEGER));
        $this->assertFalse($transformer->canTransform('A string', Type::STRING));
    }

    public function testRequestConverter(): void
    {
        $transformer = new HttpMessageConverter(subresolve: true);
        $subject = new Request('GET', 'https://user:pwd@example.com:1234/path/to/file?q1=1#f1', [], 'Hello world');

        $this->assertEquals((object)[
            'uri' => (object)[
                'scheme' => 'https',
                'authority' => 'user:pwd@example.com:1234',
                'userInfo' => 'user:pwd',
                'host' => 'example.com',
                'port' => 1234,
                'path' => '/path/to/file',
                'query' => 'q1=1',
                'fragment' => 'f1',
            ],
            'requestTarget' => '/path/to/file?q1=1',
            'method' => 'GET',
            'protocolVersion' => '1.1',
            'headers' => (object)[
                'Host' => 'example.com:1234',
            ],
            'body' => 'Hello world',
        ], $transformer->transform($subject));
        $this->assertEquals([
            'uri' => [
                'scheme' => 'https',
                'authority' => 'user:pwd@example.com:1234',
                'userInfo' => 'user:pwd',
                'host' => 'example.com',
                'port' => 1234,
                'path' => '/path/to/file',
                'query' => 'q1=1',
                'fragment' => 'f1',
            ],
            'requestTarget' => '/path/to/file?q1=1',
            'method' => 'GET',
            'protocolVersion' => '1.1',
            'headers' => [
                'Host' => 'example.com:1234',
            ],
            'body' => 'Hello world',
        ], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame('GET /path/to/file?q1=1 HTTP/1.1', $transformer->transform($subject, Type::STRING));
        $this->assertFalse($transformer->canTransform($subject, Type::INTEGER));
        $this->assertFalse($transformer->canTransform('A string', Type::STRING));
    }

    public function testServerRequestConverter(): void
    {
        $transformer = new HttpMessageConverter(subresolve: true);
        $subject = new ServerRequest(
            'GET',
            'https://user:pwd@example.com:1234/path/to/file?q1=1#f1',
            [],
            'Hello world'
        );

        $this->assertEquals((object)[
            'uri' => (object)[
                'scheme' => 'https',
                'authority' => 'user:pwd@example.com:1234',
                'userInfo' => 'user:pwd',
                'host' => 'example.com',
                'port' => 1234,
                'path' => '/path/to/file',
                'query' => 'q1=1',
                'fragment' => 'f1',
            ],
            'requestTarget' => '/path/to/file?q1=1',
            'method' => 'GET',
            'protocolVersion' => '1.1',
            'headers' => (object)[
                'Host' => 'example.com:1234',
            ],
            'body' => 'Hello world',
            'serverParams' => (object)[],
            'cookieParams' => (object)[],
            'queryParams' => (object)[
                'q1' => '1',
            ],
            'attributes' => (object)[],
        ], $transformer->transform($subject));
        $this->assertEquals([
            'uri' => [
                'scheme' => 'https',
                'authority' => 'user:pwd@example.com:1234',
                'userInfo' => 'user:pwd',
                'host' => 'example.com',
                'port' => 1234,
                'path' => '/path/to/file',
                'query' => 'q1=1',
                'fragment' => 'f1',
            ],
            'requestTarget' => '/path/to/file?q1=1',
            'method' => 'GET',
            'protocolVersion' => '1.1',
            'headers' => [
                'Host' => 'example.com:1234',
            ],
            'body' => 'Hello world',
            'serverParams' => [],
            'cookieParams' => [],
            'queryParams' => [
                'q1' => '1',
            ],
            'attributes' => [],
        ], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame('GET /path/to/file?q1=1 HTTP/1.1', $transformer->transform($subject, Type::STRING));
        $this->assertFalse($transformer->canTransform($subject, Type::INTEGER));
        $this->assertFalse($transformer->canTransform('A string', Type::STRING));
    }

    public function testResponseConverter(): void
    {
        $transformer = new HttpMessageConverter();
        $subject = new Response(200, [], "Hello world");

        $this->assertEquals((object)[
            'protocolVersion' => '1.1',
            'headers' => (object)[],
            'body' => 'Hello world',
            'statusCode' => 200,
            'reasonPhrase' => 'OK',
        ], $transformer->transform($subject));
        $this->assertEquals([
            'protocolVersion' => '1.1',
            'headers' => [],
            'body' => 'Hello world',
            'statusCode' => 200,
            'reasonPhrase' => 'OK',
        ], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame('HTTP/1.1 200 OK', $transformer->transform($subject, Type::STRING));
        $this->assertFalse($transformer->canTransform($subject, Type::INTEGER));
        $this->assertFalse($transformer->canTransform('A string', Type::STRING));
    }

    public function testMessageConverter(): void
    {
        $transformer = new HttpMessageConverter();
        $subject = new TestHttpMessage();

        $this->assertEquals((object)[
            'protocolVersion' => '1.1',
            'headers' => (object)[],
            'body' => '',
        ], $transformer->transform($subject));
        $this->assertEquals([
            'protocolVersion' => '1.1',
            'headers' => [],
            'body' => '',
        ], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame('HTTP/1.1', $transformer->transform($subject, Type::STRING));
        $this->assertFalse($transformer->canTransform($subject, Type::INTEGER));
        $this->assertFalse($transformer->canTransform('A string', Type::STRING));
    }

    public function testConverterUnsupported(): void
    {
        $transformer = new HttpMessageConverter();
        $this->expectException(TransformerException::class);
        $this->expectExceptionMessage("HttpMessage conversion for 'string' is not supported.");
        /* @phpstan-ignore argument.type */
        $transformer->transform('A string');
    }

    public function testConverterInvalidDefault(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid 'integer' provided");
        /* @phpstan-ignore argument.type */
        $transformer = new HttpMessageConverter(default: Type::INTEGER);
    }
}
