<?php

declare (strict_types=1);
/**
 * Unit tests for the Ajax_Middleware class
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Ajax
 */
namespace PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Unit;

use PC_Woo_Stock_Man\WP_UnitTestCase;
use PC_Woo_Stock_Man\Nyholm\Psr7\Stream;
use PC_Woo_Stock_Man\PinkCrab\Nonce\Nonce;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper;
use PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Exception;
use PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Invalid_Ajax;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax;
class Test_Ajax_Helper extends \WP_UnitTestCase
{
    /** Clears the Helpers internal class cache */
    public function tearDown() : void
    {
        $helper = new \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper();
        \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::set_property($helper, 'class_cache', array());
    }
    /** @testdox A cache of all ajax classes should be created and populated with each new instance created. */
    public function test_reflected_instances_should_be_cached() : void
    {
        $helper = new \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper();
        $helper::get_action(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class);
        $this->assertArrayHasKey(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class, \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($helper, 'class_cache'));
    }
    /** @testdox It should be possible to get the handle for an Ajax class using reflection and avoiding the constructor. */
    public function test_get_ajax_handle() : void
    {
        // Valid ajax class
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::ACTION, \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_action(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class));
    }
    /** @testdox Attempting to get the action of a non Ajax class should result in an exception being thrown */
    public function test_throws_exception_getting_handle_of_non_ajax_class() : void
    {
        $this->expectException(\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Exception::class);
        $this->expectExceptionCode(100);
        \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_action(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Unit\stdClass::class);
    }
    /** @testdox Attempting to get the action of an invalid Ajax class should result in an exception being thrown */
    public function test_throws_exception_getting_handle_of_invalid_ajax_class() : void
    {
        $this->expectException(\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Exception::class);
        $this->expectExceptionCode(101);
        \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_action(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Invalid_Ajax::class);
    }
    /** @testdox It should be possible to check if an ajax class uses a nonce */
    public function test_has_nonce() : void
    {
        $this->assertTrue(\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::has_nonce(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class));
        $this->assertFalse(\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::has_nonce(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Invalid_Ajax::class));
    }
    /** @testdox It should be possible to get a nonce object for an Ajax class which has a defined nonce handle */
    public function test_get_nonce() : void
    {
        $nonce = \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_nonce(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class);
        $this->assertInstanceOf(\PC_Woo_Stock_Man\PinkCrab\Nonce\Nonce::class, $nonce);
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::NONCE_HANDLE, \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($nonce, 'action'));
    }
    /** @testdox Attempting to get a nonce object on a class with no Nonce Handle, should return null */
    public function test_returns_null_if_get_nonce_with_no_nonce_handle() : void
    {
        $this->assertNull(\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_nonce(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Invalid_Ajax::class));
    }
    /** @testdox It should be possible to get the nonce field (property holding nonce value in reqiest) for an Ajax class */
    public function test_nonce_field() : void
    {
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::NONCE_FIELD, \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_nonce_field(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class));
    }
    /** @testdox It should be possible to extract all $_GET params */
    public function test_extract_get_from_server_request() : void
    {
        $request = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::global_server_request()->withQueryParams(array('key1' => 'get1', 'key2' => 'get2'));
        $args = \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::extract_server_request_args($request);
        $this->assertCount(2, $args);
        $this->assertArrayHasKey('key1', $args);
        $this->assertArrayHasKey('key2', $args);
        $this->assertEquals('get1', $args['key1']);
        $this->assertEquals('get2', $args['key2']);
    }
    /** @testdox It should be possible to extract the JSON representation of all $_POST body values. */
    public function test_extract_post_from_server_request() : void
    {
        $request = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::global_server_request()->withBody(\PC_Woo_Stock_Man\Nyholm\Psr7\Stream::create(\json_encode(array('key1' => 'post1', 'key2' => 'post2'))))->withMethod('POST');
        $args = \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::extract_server_request_args($request);
        $this->assertCount(2, $args);
        $this->assertArrayHasKey('key1', $args);
        $this->assertArrayHasKey('key2', $args);
        $this->assertEquals('post1', $args['key1']);
        $this->assertEquals('post2', $args['key2']);
    }
    /** @testdox It should be possible to extract the parsed body from a urlEncode POST server request */
    public function test_extract_urlencode_post_from_server_request() : void
    {
        $request = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::global_server_request()->withParsedBody(array('key1' => 'urlEncode1', 'key2' => 'urlEncode2'))->withMethod('POST')->withHeader('Content-Type', 'application/x-www-form-urlencoded;');
        $args = \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::extract_server_request_args($request);
        $this->assertCount(2, $args);
        $this->assertArrayHasKey('key1', $args);
        $this->assertArrayHasKey('key2', $args);
        $this->assertEquals('urlEncode1', $args['key1']);
        $this->assertEquals('urlEncode2', $args['key2']);
    }
    /** @testdox Any method which is not GET or POST should return a blank array when extracting from Server Request */
    public function test_extract_empty_array_for_non_get_post_server_request() : void
    {
        $request = \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::global_server_request()->withParsedBody(array('key1' => 'urlEncode1', 'key2' => 'urlEncode2'))->withMethod('NOOP');
        $args = \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::extract_server_request_args($request);
        $this->assertCount(0, $args);
    }
    /** @testdox It should be possible to get the admin ajax url using the helper. */
    public function test_admin_ajax_url() : void
    {
        $this->assertEquals(admin_url('admin-ajax.php'), \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::admin_ajax_url());
    }
}
