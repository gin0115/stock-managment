<?php

declare (strict_types=1);
/**
 * Unit tests for the Ajax_Dispatcher
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Ajax
 */
namespace PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Unit;

use PC_Woo_Stock_Man\WP_UnitTestCase;
use PC_Woo_Stock_Man\PinkCrab\Loader\Hook;
use PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Exception;
use PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Controller;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Dispatcher;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Invalid_Ajax;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Repeating_Ajax;
class Test_Ajax_Dispatcher extends \WP_UnitTestCase
{
    /** @testdox The ajax dispatcher should be populated with a hook loader and the Ajax_Controller as passed. */
    public function test_instance_has_valid_states() : void
    {
        $dispatcher = new \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Dispatcher($this->createMock(\PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Controller::class));
        $this->assertInstanceOf(\PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader::class, \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($dispatcher, 'loader'));
        $this->assertInstanceOf(\PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Controller::class, \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($dispatcher, 'ajax_controller'));
    }
    /** @testdox It should be possible to add ajax calls to the dispatcher, if they have a defined Action. */
    public function test_add_ajax() : void
    {
        $dispatcher = new \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Dispatcher($this->createMock(\PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Controller::class));
        $dispatcher->add_ajax_call(new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax());
        // Get the hooks.
        $hook_loader = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($dispatcher, 'loader');
        $hooks = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($hook_loader, 'hooks');
        $hooks = $hooks->export();
        $this->assertCount(1, $hooks);
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::ACTION, $hooks[0]->get_handle());
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Loader\Hook::AJAX, $hooks[0]->get_type());
    }
    /** @testdox Attempting to add an ajax class which has no defined Action, should throw an error */
    public function test_throws_exception_if_ajax_class_has_no_action() : void
    {
        $this->expectException(\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Exception::class);
        $dispatcher = new \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Dispatcher($this->createMock(\PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Controller::class));
        $dispatcher->add_ajax_call(new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Invalid_Ajax());
    }
    /** @testdox When the dispatcher excutes, ajax call hooks should be registered with WordPress. */
    public function test_execute_registers_all_hooks() : void
    {
        $dispatcher = new \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Dispatcher($this->createMock(\PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Controller::class));
        $dispatcher->add_ajax_call(new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax());
        $dispatcher->add_ajax_call(new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Repeating_Ajax());
        $dispatcher->execute();
        // Get the hooks.
        $hook_loader = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($dispatcher, 'loader');
        $hooks = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($hook_loader, 'hooks');
        $hooks = $hooks->export();
        $this->assertTrue($hooks[0]->is_registered());
        $this->assertTrue(\has_action('wp_ajax_' . $hooks[0]->get_handle()));
        $this->assertTrue($hooks[1]->is_registered());
        $this->assertTrue(\has_action('wp_ajax_' . $hooks[1]->get_handle()));
    }
}
