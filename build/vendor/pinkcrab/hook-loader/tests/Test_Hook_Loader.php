<?php

declare (strict_types=1);
/**
 * Hook_Loader Unit Tests
 *
 * @since 1.0.1
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Loader
 */
namespace PC_Woo_Stock_Man\PinkCrab\Loader\Tests;

use PC_Woo_Stock_Man\WP_UnitTestCase;
use PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects;
use PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays as Arr;
use PC_Woo_Stock_Man\PinkCrab\Loader\Tests\Fixtures\Hook_Manager_NoOp_Mock;
use PC_Woo_Stock_Man\PinkCrab\Loader\Tests\Fixtures\Hook_Manager_Object_Mock;
use PC_Woo_Stock_Man\PinkCrab\Loader\Hook;
use PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader;
use PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Factory;
use PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Collection;
use PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Manager;
class Test_Hook_Loader extends \WP_UnitTestCase
{
    /** @testdoxA developer should be able to create a Hook Loader and have the interal objects populated.*/
    public function test_can_be_contrustucted_with_internal_resources() : void
    {
        $loader = new \PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader();
        $this->assertInstanceOf(\PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Collection::class, \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($loader, 'hooks'));
        $this->assertInstanceOf(\PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Factory::class, \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($loader, 'hook_factory'));
    }
    /** @testdox A developer should be able to add actions as either gloabl (front & admin), admin or front using the loaders methods. */
    public function test_add_actions() : void
    {
        $loader = new \PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader();
        $loader->action('global_action', 'is_string');
        $loader->admin_action('admin_action', 'is_string');
        $loader->front_action('front_action', 'is_string');
        /** @var Hook_Collection Extracted internal Collection */
        $hooks = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($loader, 'hooks');
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->get_type() === \PC_Woo_Stock_Man\PinkCrab\Loader\Hook::ACTION && $e->get_handle() === 'global_action';
        })($hooks->export()));
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->get_type() === \PC_Woo_Stock_Man\PinkCrab\Loader\Hook::ACTION && $e->get_handle() === 'admin_action';
        })($hooks->export()));
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->get_type() === \PC_Woo_Stock_Man\PinkCrab\Loader\Hook::ACTION && $e->get_handle() === 'front_action';
        })($hooks->export()));
    }
    /** @testdox A developer should be able to add filters as either gloabl (front & admin), admin or front using the loaders methods. */
    public function test_add_filters() : void
    {
        $loader = new \PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader();
        $loader->filter('global_filter', 'is_string');
        $loader->admin_filter('admin_filter', 'is_string');
        $loader->front_filter('front_filter', 'is_string');
        /** @var Hook_Collection Extracted internal Collection */
        $hooks = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($loader, 'hooks');
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->get_type() === \PC_Woo_Stock_Man\PinkCrab\Loader\Hook::FILTER && $e->get_handle() === 'global_filter';
        })($hooks->export()));
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->get_type() === \PC_Woo_Stock_Man\PinkCrab\Loader\Hook::FILTER && $e->get_handle() === 'admin_filter';
        })($hooks->export()));
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->get_type() === \PC_Woo_Stock_Man\PinkCrab\Loader\Hook::FILTER && $e->get_handle() === 'front_filter';
        })($hooks->export()));
    }
    /** @testdox A developer should be able to decalre a hook to be removed. */
    public function test_remove_hook() : void
    {
        $loader = new \PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader();
        $loader->remove('hookk', 'is_string');
        $loader->remove_filter('filter_hook', 'is_string');
        $loader->remove_action('action_hook', 'is_string');
        /** @var Hook_Collection Extracted internal Collection */
        $hooks = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($loader, 'hooks');
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->get_type() === \PC_Woo_Stock_Man\PinkCrab\Loader\Hook::REMOVE && $e->get_handle() === 'hookk';
        })($hooks->export()));
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->get_type() === \PC_Woo_Stock_Man\PinkCrab\Loader\Hook::REMOVE && $e->get_handle() === 'filter_hook';
        })($hooks->export()));
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->get_type() === \PC_Woo_Stock_Man\PinkCrab\Loader\Hook::REMOVE && $e->get_handle() === 'action_hook';
        })($hooks->export()));
    }
    /** @testdox A developer shoud be able to add ajax calls for either and public (none logged in) and private (logged in) users */
    public function test_ajax() : void
    {
        $loader = new \PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader();
        $loader->ajax('either', 'is_string');
        $loader->ajax('only_public', 'is_string', \true, \false);
        $loader->ajax('only_private', 'is_string', \false, \true);
        /** @var Hook_Collection Extracted internal Collection */
        $hooks = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($loader, 'hooks');
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->get_type() === \PC_Woo_Stock_Man\PinkCrab\Loader\Hook::AJAX && $e->get_handle() === 'either' && $e->is_ajax_public() === \true && $e->is_ajax_private() === \true;
        })($hooks->export()));
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->get_type() === \PC_Woo_Stock_Man\PinkCrab\Loader\Hook::AJAX && $e->get_handle() === 'only_public' && $e->is_ajax_public() === \true && $e->is_ajax_private() === \false;
        })($hooks->export()));
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->get_type() === \PC_Woo_Stock_Man\PinkCrab\Loader\Hook::AJAX && $e->get_handle() === 'only_private' && $e->is_ajax_public() === \false && $e->is_ajax_private() === \true;
        })($hooks->export()));
    }
    /** @testdox A developer should be able to add a shortcode */
    public function test_shortcode() : void
    {
        $loader = new \PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader();
        $loader->shortcode('my_shortcode', 'is_string');
        /** @var Hook_Collection Extracted internal Collection */
        $hooks = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($loader, 'hooks');
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->get_type() === \PC_Woo_Stock_Man\PinkCrab\Loader\Hook::SHORTCODE && $e->get_handle() === 'my_shortcode';
        })($hooks->export()));
    }
    /** @testdox When all hooks are registered, those that are have their status updated. */
    public function test_register_hooks() : void
    {
        $loader = new \PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader();
        $loader->filter('global_filter', 'is_string');
        // Process use mock manager (just marks the hooks as registered)
        $loader->register_hooks(new \PC_Woo_Stock_Man\PinkCrab\Loader\Tests\Fixtures\Hook_Manager_NoOp_Mock());
        /** @var Hook_Collection Extracted internal Collection */
        $hooks = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($loader, 'hooks');
        $this->assertEquals(1, \PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays\filterCount(function ($e) {
            return $e->is_registered();
        })($hooks->export()));
    }
}
