<?php

declare (strict_types=1);
namespace PC_Woo_Stock_Man\Nyholm\Psr7\Factory;

use PC_Woo_Stock_Man\Http\Message\MessageFactory;
use PC_Woo_Stock_Man\Http\Message\StreamFactory;
use PC_Woo_Stock_Man\Http\Message\UriFactory;
use PC_Woo_Stock_Man\Nyholm\Psr7\Request;
use PC_Woo_Stock_Man\Nyholm\Psr7\Response;
use PC_Woo_Stock_Man\Nyholm\Psr7\Stream;
use PC_Woo_Stock_Man\Nyholm\Psr7\Uri;
use PC_Woo_Stock_Man\Psr\Http\Message\RequestInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\StreamInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\UriInterface;
/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 * @author Martijn van der Ven <martijn@vanderven.se>
 *
 * @final This class should never be extended. See https://github.com/Nyholm/psr7/blob/master/doc/final.md
 */
class HttplugFactory implements \PC_Woo_Stock_Man\Http\Message\MessageFactory, \PC_Woo_Stock_Man\Http\Message\StreamFactory, \PC_Woo_Stock_Man\Http\Message\UriFactory
{
    public function createRequest($method, $uri, array $headers = [], $body = null, $protocolVersion = '1.1') : \PC_Woo_Stock_Man\Psr\Http\Message\RequestInterface
    {
        return new \PC_Woo_Stock_Man\Nyholm\Psr7\Request($method, $uri, $headers, $body, $protocolVersion);
    }
    public function createResponse($statusCode = 200, $reasonPhrase = null, array $headers = [], $body = null, $version = '1.1') : \PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface
    {
        return new \PC_Woo_Stock_Man\Nyholm\Psr7\Response((int) $statusCode, $headers, $body, $version, $reasonPhrase);
    }
    public function createStream($body = null) : \PC_Woo_Stock_Man\Psr\Http\Message\StreamInterface
    {
        return \PC_Woo_Stock_Man\Nyholm\Psr7\Stream::create($body ?? '');
    }
    public function createUri($uri = '') : \PC_Woo_Stock_Man\Psr\Http\Message\UriInterface
    {
        if ($uri instanceof \PC_Woo_Stock_Man\Psr\Http\Message\UriInterface) {
            return $uri;
        }
        return new \PC_Woo_Stock_Man\Nyholm\Psr7\Uri($uri);
    }
}
