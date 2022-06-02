<?php

declare (strict_types=1);
/**
 * Unit tests for the Ajax Response Factory
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Ajax
 */
namespace PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Unit;

use PC_Woo_Stock_Man\WP_UnitTestCase;
use PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP;
use PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Response_Factory;
class Test_Response_Factory extends \WP_UnitTestCase
{
    /**
     * Returns a populate factory instance.
     *
     * @return \PinkCrab\Ajax\Dispatcher\Response_Factory
     */
    public function factory_provider() : \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Response_Factory
    {
        return new \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Response_Factory(new \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP());
    }
    /** @testdox When creating an instance of the response factory all internal states and dependencies should be set. */
    public function test_instantiation_sets_http_helper() : void
    {
        $factory = new \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Response_Factory($this->createMock(\PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP::class));
        $this->assertInstanceOf(\PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP::class, \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($factory, 'http'));
    }
    /** @testdox It should be possible to create a custom response using the PSR  */
    public function test_can_create_custom_response() : void
    {
        $response = $this->factory_provider()->createResponse(200, 'body');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('body', (string) $response->getBody());
    }
    /** @testdox It should be possible to create a simple 200 response from a sclar value. */
    public function test_can_create_success_response() : void
    {
        $response = $this->factory_provider()->success(array('winner'));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('winner', \json_decode((string) $response->getBody()));
    }
    /** @testdox It should be possible to create a simple 404 response from a sclar value. */
    public function test_can_create_not_found_response() : void
    {
        $response = $this->factory_provider()->not_found();
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('not found', \json_decode((string) $response->getBody())->error);
    }
    /** @testdox It should be possible to create a simple 401 response from a sclar value. */
    public function test_can_create_unauthorised_response() : void
    {
        $response = $this->factory_provider()->unauthorised();
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('unauthorised', \json_decode((string) $response->getBody())->error);
    }
    /** @testdox It should be possible to create a simple 500 response from a sclar value. */
    public function test_can_create_failure_response() : void
    {
        $response = $this->factory_provider()->failure();
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('error', \json_decode((string) $response->getBody())->error);
    }
}
