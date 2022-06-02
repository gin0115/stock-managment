<?php

declare (strict_types=1);
namespace PC_Woo_Stock_Man\Nyholm\Psr7\Factory;

use PC_Woo_Stock_Man\Nyholm\Psr7\Request;
use PC_Woo_Stock_Man\Nyholm\Psr7\Response;
use PC_Woo_Stock_Man\Nyholm\Psr7\ServerRequest;
use PC_Woo_Stock_Man\Nyholm\Psr7\Stream;
use PC_Woo_Stock_Man\Nyholm\Psr7\UploadedFile;
use PC_Woo_Stock_Man\Nyholm\Psr7\Uri;
use PC_Woo_Stock_Man\Psr\Http\Message\RequestFactoryInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\RequestInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\ResponseFactoryInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestFactoryInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\StreamFactoryInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\StreamInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\UploadedFileFactoryInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\UploadedFileInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\UriFactoryInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\UriInterface;
/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 * @author Martijn van der Ven <martijn@vanderven.se>
 *
 * @final This class should never be extended. See https://github.com/Nyholm/psr7/blob/master/doc/final.md
 */
class Psr17Factory implements \PC_Woo_Stock_Man\Psr\Http\Message\RequestFactoryInterface, \PC_Woo_Stock_Man\Psr\Http\Message\ResponseFactoryInterface, \PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestFactoryInterface, \PC_Woo_Stock_Man\Psr\Http\Message\StreamFactoryInterface, \PC_Woo_Stock_Man\Psr\Http\Message\UploadedFileFactoryInterface, \PC_Woo_Stock_Man\Psr\Http\Message\UriFactoryInterface
{
    public function createRequest(string $method, $uri) : \PC_Woo_Stock_Man\Psr\Http\Message\RequestInterface
    {
        return new \PC_Woo_Stock_Man\Nyholm\Psr7\Request($method, $uri);
    }
    public function createResponse(int $code = 200, string $reasonPhrase = '') : \PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface
    {
        if (2 > \func_num_args()) {
            // This will make the Response class to use a custom reasonPhrase
            $reasonPhrase = null;
        }
        return new \PC_Woo_Stock_Man\Nyholm\Psr7\Response($code, [], null, '1.1', $reasonPhrase);
    }
    public function createStream(string $content = '') : \PC_Woo_Stock_Man\Psr\Http\Message\StreamInterface
    {
        return \PC_Woo_Stock_Man\Nyholm\Psr7\Stream::create($content);
    }
    public function createStreamFromFile(string $filename, string $mode = 'r') : \PC_Woo_Stock_Man\Psr\Http\Message\StreamInterface
    {
        if ('' === $filename) {
            throw new \RuntimeException('Path cannot be empty');
        }
        if (\false === ($resource = @\fopen($filename, $mode))) {
            if ('' === $mode || \false === \in_array($mode[0], ['r', 'w', 'a', 'x', 'c'], \true)) {
                throw new \InvalidArgumentException(\sprintf('The mode "%s" is invalid.', $mode));
            }
            throw new \RuntimeException(\sprintf('The file "%s" cannot be opened: %s', $filename, \error_get_last()['message'] ?? ''));
        }
        return \PC_Woo_Stock_Man\Nyholm\Psr7\Stream::create($resource);
    }
    public function createStreamFromResource($resource) : \PC_Woo_Stock_Man\Psr\Http\Message\StreamInterface
    {
        return \PC_Woo_Stock_Man\Nyholm\Psr7\Stream::create($resource);
    }
    public function createUploadedFile(\PC_Woo_Stock_Man\Psr\Http\Message\StreamInterface $stream, int $size = null, int $error = \UPLOAD_ERR_OK, string $clientFilename = null, string $clientMediaType = null) : \PC_Woo_Stock_Man\Psr\Http\Message\UploadedFileInterface
    {
        if (null === $size) {
            $size = $stream->getSize();
        }
        return new \PC_Woo_Stock_Man\Nyholm\Psr7\UploadedFile($stream, $size, $error, $clientFilename, $clientMediaType);
    }
    public function createUri(string $uri = '') : \PC_Woo_Stock_Man\Psr\Http\Message\UriInterface
    {
        return new \PC_Woo_Stock_Man\Nyholm\Psr7\Uri($uri);
    }
    public function createServerRequest(string $method, $uri, array $serverParams = []) : \PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface
    {
        return new \PC_Woo_Stock_Man\Nyholm\Psr7\ServerRequest($method, $uri, [], null, '1.1', $serverParams);
    }
}
