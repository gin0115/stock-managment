<?php

namespace PC_Woo_Stock_Man;

/**
 * Sample Test
 *
 * @package PinkCrab/Tests
 */
use PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP;
use PHPUnit\Framework\Exception;
use PC_Woo_Stock_Man\Psr\Http\Message\UriInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\RequestInterface;
// use PHPUnit\Framework\TestCase;
use PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface;
use PC_Woo_Stock_Man\Yoast\PHPUnitPolyfills\TestCases\TestCase;
// use WP_Ajax_UnitTestCase;
/**
 *      *
 * @preserdveGlobalState disabled
 */
class Test_HTTP extends \PC_Woo_Stock_Man\Yoast\PHPUnitPolyfills\TestCases\TestCase
{
    /**
     * Undocumented variable
     *
     * @var bool
     */
    protected $preserveGlobalState = \false;
    /**
     * Test that we can creatre a WP_HTTP_Response
     *
     * @return void
     */
    public function test_can_create_wp_http_response() : void
    {
        $http = new \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP();
        $repsonse = $http->wp_response(array('key' => 'test_VALUE'), 500);
        $this->assertInstanceOf(\WP_HTTP_Response::class, $repsonse);
        $this->assertIsArray($repsonse->get_data());
        $this->assertArrayHasKey('key', $repsonse->get_data());
        $this->assertEquals('test_VALUE', $repsonse->get_data()['key']);
        $this->assertEquals(500, $repsonse->get_status());
    }
    /**
     * Tests that a WP_Response can be generated and emmited.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function test_can_emit_wp_response() : void
    {
        $http = new \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP();
        $repsonse = $http->wp_response(array('key' => 'WP_VALUE'));
        $this->expectOutputRegex('/^(.*?(\\bWP_VALUE\\b)[^$]*)$/');
        $http->emit_response($repsonse);
    }
    /**
     * Test that we can creatre a psr7 Response
     *
     * @return void
     */
    public function test_can_create_psr7_respnse() : void
    {
        $http = new \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP();
        $repsonse = $http->psr7_response(array('key' => 'test_VALUE'), 500);
        $body = \json_decode((string) $repsonse->getBody(), \true);
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface::class, $repsonse);
        $this->assertIsArray($body);
        $this->assertArrayHasKey('key', $body);
        $this->assertEquals('test_VALUE', $body['key']);
        $this->assertEquals(500, $repsonse->getStatusCode());
    }
    /**
     * Tests that a ResponseInterface can be generated and emmited.
     *
     * @runInSeparateProcess
     * @return void
     */
    function test_can_emit_psr7_response() : void
    {
        $http = new \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP();
        $repsonse = $http->psr7_response(array('key' => 'ps7_value'));
        $this->expectOutputRegex('/^(.*?(\\bps7_value\\b)[^$]*)$/');
        $http->emit_response($repsonse);
    }
    /**
     * Tests that JSON header is added to array if not set.
     *
     * @return void
     */
    public function test_headers_with_json() : void
    {
        // Test with empty array, should add.
        $mock_header = array();
        $mock_header = (new \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP())->headers_with_json($mock_header);
        $this->assertArrayHasKey('Content-Type', $mock_header);
        $this->assertStringContainsString('application/json', $mock_header['Content-Type']);
        // Ensure that content type not over written.
        $mock_header2['Content-Type'] = 'NOPE';
        $mock_header2 = (new \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP())->headers_with_json($mock_header2);
        $this->assertStringNotContainsString('application/json', $mock_header2['Content-Type']);
    }
    /**
     * Test that request wrapper works.
     *
     * @return void
     */
    public function test_psr7_request() : void
    {
        $http = new \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP();
        $request = $http->psr7_request('GET', 'https://google.com');
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Psr\Http\Message\RequestInterface::class, $request);
        $this->assertEquals('GET', $request->getMethod());
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Psr\Http\Message\UriInterface::class, $request->getUri());
        $this->assertEquals('google.com', $request->getUri()->getHost());
    }
    /**
     * Test throws exception if no repsonse passed to emit_reponse.
     *
     * @return void
     */
    public function test_emit_throw_if_none_valid_response_type() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        $http = new \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP();
        $http->emit_response((object) array('not' => 'valid'));
    }
    /**
     * Test can produce stream from data which can be cast to JSON.
     *
     * @return void
     */
    public function test_can_create_stream_from_jsonable_data() : void
    {
        $http = new \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP();
        $withArray = $http->stream_from_scalar(array('key' => 'value'));
        $withObject = $http->stream_from_scalar((object) array('key' => 'value'));
        $withString = $http->stream_from_scalar('STRING');
        $withInt = $http->stream_from_scalar(42);
        $withFloat = $http->stream_from_scalar(4.2);
        $this->assertEquals('{"key":"value"}', (string) $withArray);
        $this->assertEquals('{"key":"value"}', (string) $withObject);
        $this->assertEquals('"STRING"', (string) $withString);
        $this->assertEquals(42, (string) $withInt);
        $this->assertEquals(4.2, (string) $withFloat);
    }
}
// use WP_Ajax_UnitTestCase;
/**
 *      *
 * @preserdveGlobalState disabled
 */
\class_alias('PC_Woo_Stock_Man\\Test_HTTP', 'Test_HTTP', \false);
