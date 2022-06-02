<?php

namespace PC_Woo_Stock_Man;

/**
 * Tests the HTTP_Helper class
 * Just calls methods in HTTP but with a nicer static interface.
 *
 * @package PinkCrab/Tests
 */
use PC_Woo_Stock_Man\Nyholm\Psr7\Stream;
use PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP;
use PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper;
use PC_Woo_Stock_Man\Psr\Http\Message\UriInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\RequestInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface;
use PC_Woo_Stock_Man\Yoast\PHPUnitPolyfills\TestCases\TestCase;
class Test_HTTP_Helper extends \PC_Woo_Stock_Man\Yoast\PHPUnitPolyfills\TestCases\TestCase
{
    /**
     * Test the helper can return the inner HTTP instance.
     *
     * @return void
     */
    public function test_can_get_http_instance()
    {
        $this->assertInstanceOf(\PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP::class, \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::get_http());
    }
    /**
     * Test that we can creatre a WP_HTTP_Response
     *
     * @return void
     */
    public function test_can_create_wp_http_response() : void
    {
        $repsonse = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::wp_response(array('key' => 'test_VALUE'), 500);
        $this->assertInstanceOf(\WP_HTTP_Response::class, $repsonse);
        $this->assertIsArray($repsonse->get_data());
        $this->assertArrayHasKey('key', $repsonse->get_data());
        $this->assertEquals('test_VALUE', $repsonse->get_data()['key']);
        $this->assertEquals(500, $repsonse->get_status());
    }
    /**
     * Test that we can creatre a psr7 Response
     *
     * @return void
     */
    public function test_can_create_psr7_respnse() : void
    {
        $repsonse = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::response(array('key' => 'test_VALUE'), 500);
        $body = \json_decode((string) $repsonse->getBody(), \true);
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface::class, $repsonse);
        $this->assertIsArray($body);
        $this->assertArrayHasKey('key', $body);
        $this->assertEquals('test_VALUE', $body['key']);
        $this->assertEquals(500, $repsonse->getStatusCode());
    }
    /**
     * Test that request wrapper works.
     *
     * @return void
     */
    public function test_psr7_request() : void
    {
        $request = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::request('GET', 'https://google.com');
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Psr\Http\Message\RequestInterface::class, $request);
        $this->assertEquals('GET', $request->getMethod());
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Psr\Http\Message\UriInterface::class, $request->getUri());
        $this->assertEquals('google.com', $request->getUri()->getHost());
    }
    /**
     * Test can produce stream from data which can be cast to JSON.
     *
     * @return void
     */
    public function test_can_create_stream_from_jsonable_data() : void
    {
        $withArray = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::stream_from_scalar(array('key' => 'value'));
        $withObject = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::stream_from_scalar((object) array('key' => 'value'));
        $withString = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::stream_from_scalar('STRING');
        $withInt = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::stream_from_scalar(42);
        $withFloat = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::stream_from_scalar(4.2);
        // Chececk all streams.
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Nyholm\Psr7\Stream::class, $withArray);
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Nyholm\Psr7\Stream::class, $withObject);
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Nyholm\Psr7\Stream::class, $withString);
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Nyholm\Psr7\Stream::class, $withInt);
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Nyholm\Psr7\Stream::class, $withFloat);
        // Check values.
        $this->assertEquals('{"key":"value"}', (string) $withArray);
        $this->assertEquals('{"key":"value"}', (string) $withObject);
        $this->assertEquals('"STRING"', (string) $withString);
        $this->assertEquals(42, (string) $withInt);
        $this->assertEquals(4.2, (string) $withFloat);
    }
    /**
     * Test can get a populated server request.
     * As $_GET
     * @return void
     */
    public function test_can_get_global_server_request_get() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['http_helper_get'] = 'GET';
        $server_request = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::global_server_request();
        $this->assertTrue($server_request instanceof \PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface);
        // Get the _GET
        $this->assertIsArray($server_request->getQueryParams());
        $this->assertArrayHasKey('http_helper_get', $server_request->getQueryParams());
        $this->assertEquals('GET', $server_request->getQueryParams()['http_helper_get']);
    }
    /**
     * Test can get a populated server request.
     * As $_POST
     * @return void
     */
    public function test_can_get_global_server_request_post()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['http_helper_post'] = 'POST';
        $server_request = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::global_server_request();
        $this->assertTrue($server_request instanceof \PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface);
        // Get the stream.
        $stream = $server_request->getBody();
        $this->assertIsString($stream->getContents());
        $this->assertIsString((string) $stream);
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Nyholm\Psr7\Stream::class, $stream);
        $decoded_body = \json_decode((string) $stream, \true);
        $this->assertArrayHasKey('http_helper_post', $decoded_body);
        $this->assertEquals('POST', $decoded_body['http_helper_post']);
    }
}
\class_alias('PC_Woo_Stock_Man\\Test_HTTP_Helper', 'Test_HTTP_Helper', \false);
