<?php

declare (strict_types=1);
/**
 * Intergration test of the Simple Get Ajax Call
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Ajax
 */
namespace PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Intergration;

use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper;
use PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper;
use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax_BaseCase;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax;
class Test_Simple_Get extends \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax_BaseCase
{
    /**
     * @testdox A user should be able to make a call against a valid ajax action. Where the data passed is via GET and has a valid (required) nonce, which returns a 200
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_get_request_successful() : void
    {
        // Log in user
        $this->_setRole('subscriber');
        // Mock the request.
        $_GET[\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_nonce_field(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class)] = \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_nonce(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class)->token();
        $dispatcher = $this->ajax_dispatcher_provider();
        $dispatcher->add_ajax_call(new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax());
        $dispatcher->execute();
        try {
            $this->_handleAjax(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::ACTION);
        } catch (\WPAjaxDieContinueException $e) {
        }
        $response = \json_decode($this->_last_response);
        $this->assertTrue(\property_exists($response, 'success'));
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class, $response->success);
        $this->assertEquals(200, \http_response_code());
    }
    /**
     * @testdox A user should be able to make a call against a valid ajax action. Where the data passed is via POST(urlencoded) and has a valid (required) nonce, which returns a 200
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_urlencoded_request_successful() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        // Log in user
        $this->_setRole('subscriber');
        // Mock the request.
        $dispatcher = $this->ajax_dispatcher_provider(function (\PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface $request) : ServerRequestInterface {
            return $request->withParsedBody(array(\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_nonce_field(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class) => \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_nonce(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class)->token()))->withHeader('Content-Type', 'application/x-www-form-urlencoded;');
        });
        $dispatcher->add_ajax_call(new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax());
        $dispatcher->execute();
        try {
            $this->_handleAjax(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::ACTION);
        } catch (\WPAjaxDieContinueException $e) {
        }
        $response = \json_decode($this->_last_response);
        $this->assertTrue(\property_exists($response, 'success'));
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class, $response->success);
        $this->assertEquals(200, \http_response_code());
    }
    /**
     * @testdox A user should be able to make a call against a valid ajax action. Where the data passed is via POST and has a valid (required) nonce, which returns a 200
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_post_request_successful() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        // Log in user
        $this->_setRole('subscriber');
        // Mock the request.
        $dispatcher = $this->ajax_dispatcher_provider(function (\PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface $request) : ServerRequestInterface {
            return $request->withBody(\PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::stream_from_scalar(array(\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_nonce_field(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class) => \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_nonce(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class)->token())));
        });
        $dispatcher->add_ajax_call(new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax());
        $dispatcher->execute();
        try {
            $this->_handleAjax(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::ACTION);
        } catch (\WPAjaxDieContinueException $e) {
        }
        $response = \json_decode($this->_last_response);
        $this->assertTrue(\property_exists($response, 'success'));
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class, $response->success);
        $this->assertEquals(200, \http_response_code());
    }
    /**
     * FAILURES
     */
    /**
     * @testdox A user should be able to make a call against a valid ajax action. Where the data passed is via GET and has a invalid (but required) nonce, which returns a 401
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_get_request_fail() : void
    {
        // Log in user
        $this->_setRole('subscriber');
        // Mock the request.
        $_GET[\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_nonce_field(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class)] = 'fail';
        $dispatcher = $this->ajax_dispatcher_provider();
        $dispatcher->add_ajax_call(new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax());
        $dispatcher->execute();
        try {
            $this->_handleAjax(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::ACTION);
        } catch (\WPAjaxDieContinueException $e) {
        }
        $response = \json_decode($this->_last_response);
        $this->assertTrue(\property_exists($response, 'error'));
        $this->assertEquals('unauthorised', $response->error);
        $this->assertEquals(401, \http_response_code());
    }
    /**
     * @testdox A user should be able to make a call against a valid ajax action. Where the data passed is via POST(urlencoded) and has a invalid (but required) nonce, which returns a 401
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_urlencoded_request_fail() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        // Log in user
        $this->_setRole('subscriber');
        // Mock the request.
        $dispatcher = $this->ajax_dispatcher_provider(function (\PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface $request) : ServerRequestInterface {
            return $request->withParsedBody(array(\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_nonce_field(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class) => 'fail'))->withHeader('Content-Type', 'application/x-www-form-urlencoded;');
        });
        $dispatcher->add_ajax_call(new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax());
        $dispatcher->execute();
        try {
            $this->_handleAjax(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::ACTION);
        } catch (\WPAjaxDieContinueException $e) {
        }
        $response = \json_decode($this->_last_response);
        $this->assertTrue(\property_exists($response, 'error'));
        $this->assertEquals('unauthorised', $response->error);
        $this->assertEquals(401, \http_response_code());
    }
    /**
     * @testdox A user should be able to make a call against a valid ajax action. Where the data passed is via POST and has a invalid (but required) nonce, which returns a 401
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_post_request_fail() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        // Log in user
        $this->_setRole('subscriber');
        // Mock the request.
        $dispatcher = $this->ajax_dispatcher_provider(function (\PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface $request) : ServerRequestInterface {
            return $request->withBody(\PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper::stream_from_scalar(array(\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::get_nonce_field(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class) => 'fail')));
        });
        $dispatcher->add_ajax_call(new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax());
        $dispatcher->execute();
        try {
            $this->_handleAjax(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::ACTION);
        } catch (\WPAjaxDieContinueException $e) {
        }
        $response = \json_decode($this->_last_response);
        $this->assertTrue(\property_exists($response, 'error'));
        $this->assertEquals('unauthorised', $response->error);
        $this->assertEquals(401, \http_response_code());
    }
}
