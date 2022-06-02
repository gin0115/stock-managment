<?php

declare (strict_types=1);
/**
 * Hook Manger unit tests.
 * Uses Mock Manager
 *
 * @since 1.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Loader
 */
namespace PC_Woo_Stock_Man\PinkCrab\Loader\Tests;

use PC_Woo_Stock_Man\WP_UnitTestCase;
use ReflectionFunction;
use PC_Woo_Stock_Man\PinkCrab\Loader\Hook;
use PC_Woo_Stock_Man\Automattic\Jetpack\Constants;
use PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects;
use PC_Woo_Stock_Man\PinkCrab\Loader\Tests\Fixtures\Hook_Manager_Object_Mock;
use PC_Woo_Stock_Man\PinkCrab\Loader\Exceptions\Invalid_Hook_Callback_Exception;
class Test_Hook_Manager extends \WP_UnitTestCase
{
    /** @testdox When a hook is passed to the manager, it should be directed to the correct method for registration. */
    public function test_hooks_are_processed_by_correct_register_method()
    {
        // Create all hook types
        $action = (new \PC_Woo_Stock_Man\PinkCrab\Loader\Hook('action', 'is_string'))->type(\PC_Woo_Stock_Man\PinkCrab\Loader\Hook::ACTION);
        $filter = (new \PC_Woo_Stock_Man\PinkCrab\Loader\Hook('filter', 'is_bool'))->type(\PC_Woo_Stock_Man\PinkCrab\Loader\Hook::FILTER);
        $remove = (new \PC_Woo_Stock_Man\PinkCrab\Loader\Hook('remove', 'is_int'))->type(\PC_Woo_Stock_Man\PinkCrab\Loader\Hook::REMOVE);
        $manager = new \PC_Woo_Stock_Man\PinkCrab\Loader\Tests\Fixtures\Hook_Manager_Object_Mock();
        // Process them.
        $manager->process_hook($action);
        $manager->process_hook($filter);
        $manager->process_hook($remove);
        $this->assertCount(1, $manager->_hooks['actions']);
        $this->assertEquals('is_string', $manager->_hooks['actions']['action']['callback']);
        $this->assertCount(1, $manager->_hooks['filters']);
        $this->assertEquals('is_bool', $manager->_hooks['filters']['filter']['callback']);
        $this->assertCount(1, $manager->_hooks['remove']);
        $this->assertEquals('is_int', $manager->_hooks['remove']['remove']['callback']);
    }
    /** @testdox When an invalid hook type is passed, it should not be processed. */
    public function test_invalid_hook_types_are_not_processed() : void
    {
        $invalid = (new \PC_Woo_Stock_Man\PinkCrab\Loader\Hook('remove', 'is_int'))->type('INVALID');
        $manager = new \PC_Woo_Stock_Man\PinkCrab\Loader\Tests\Fixtures\Hook_Manager_Object_Mock();
        $invalid = $manager->process_hook($invalid);
        $this->assertFalse($invalid->is_registered());
    }
    public function FunctionName(\PC_Woo_Stock_Man\PinkCrab\Loader\Tests\Type $var = null)
    {
        # code...
    }
}
