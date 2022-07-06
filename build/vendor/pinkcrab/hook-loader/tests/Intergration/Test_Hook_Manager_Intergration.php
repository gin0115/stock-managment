<?php

declare (strict_types=1);
/**
 * Hook Manger Intergration tests.
 *
 * @since 1.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Loader
 */
namespace pc_stock_man_v1\PinkCrab\Loader\Tests\Intergration;

use pc_stock_man_v1\WP_UnitTestCase;
use pc_stock_man_v1\PinkCrab\Loader\Hook;
use pc_stock_man_v1\PinkCrab\Loader\Hook_Loader;
use pc_stock_man_v1\PinkCrab\Loader\Hook_Manager;
use pc_stock_man_v1\PinkCrab\Loader\Tests\Fixtures\Hook_Manager_Object_Mock;
use pc_stock_man_v1\PinkCrab\Loader\Exceptions\Invalid_Hook_Callback_Exception;
class Test_Hook_Manager_Intergration extends \WP_UnitTestCase
{
    /** @testdox When a hook is passed, it should only be registerd based in its admin & front values.  */
    public function test_verify_context() : void
    {
        // Hooks
        $global = new \pc_stock_man_v1\PinkCrab\Loader\Hook('global', 'is_string');
        $admin = (new \pc_stock_man_v1\PinkCrab\Loader\Hook('admin', 'is_string'))->front(\false);
        // Front & Admin true by default.
        $front = (new \pc_stock_man_v1\PinkCrab\Loader\Hook('front', 'is_string'))->admin(\false);
        // Front
        $manager_front = new \pc_stock_man_v1\PinkCrab\Loader\Tests\Fixtures\Hook_Manager_Object_Mock();
        $manager_front->process_hook($global);
        $manager_front->process_hook($admin);
        $manager_front->process_hook($front);
        $this->assertCount(2, $manager_front->_hooks['actions']);
        $this->assertArrayHasKey('global', $manager_front->_hooks['actions']);
        $this->assertArrayHasKey('front', $manager_front->_hooks['actions']);
        // Admin
        set_current_screen('edit.php');
        $manager_admin = new \pc_stock_man_v1\PinkCrab\Loader\Tests\Fixtures\Hook_Manager_Object_Mock();
        $manager_admin->process_hook($global);
        $manager_admin->process_hook($admin);
        $manager_admin->process_hook($front);
        $this->assertCount(2, $manager_admin->_hooks['actions']);
        $this->assertArrayHasKey('global', $manager_admin->_hooks['actions']);
        $this->assertArrayHasKey('admin', $manager_admin->_hooks['actions']);
        unset($GLOBALS['current_screen']);
    }
    /** @testdox When a valid action is processed and should be registered as a valid action wtih WP. */
    public function test_register_action() : void
    {
        $hook = new \pc_stock_man_v1\PinkCrab\Loader\Hook('my_action', 'is_string');
        $manager = new \pc_stock_man_v1\PinkCrab\Loader\Hook_Manager();
        $manager->process_hook($hook);
        $this->assertTrue(has_action('my_action'));
    }
    /** @testdox When an invalid callback is passed when registering an action, an error should be thrown. */
    public function test_throws_exception_with_invlalid_action_callback() : void
    {
        $this->expectException(\pc_stock_man_v1\PinkCrab\Loader\Exceptions\Invalid_Hook_Callback_Exception::class);
        $hook = new \pc_stock_man_v1\PinkCrab\Loader\Hook('my_action', 'no_Callback_HERE');
        $manager = new \pc_stock_man_v1\PinkCrab\Loader\Hook_Manager();
        $manager->process_hook($hook);
    }
    /** @testdox When a valid filter is processed and should be registered as a valid action wtih WP. */
    public function test_register_filter() : void
    {
        $hook = new \pc_stock_man_v1\PinkCrab\Loader\Hook('my_filter', 'is_string');
        $hook->type(\pc_stock_man_v1\PinkCrab\Loader\Hook::FILTER);
        $manager = new \pc_stock_man_v1\PinkCrab\Loader\Hook_Manager();
        $manager->process_hook($hook);
        $this->assertTrue(has_filter('my_filter'));
    }
    /** @testdox When an invalid callback is passed when registering an filter, an error should be thrown. */
    public function test_throws_exception_with_invlalid_filter_callback() : void
    {
        $this->expectException(\pc_stock_man_v1\PinkCrab\Loader\Exceptions\Invalid_Hook_Callback_Exception::class);
        $hook = new \pc_stock_man_v1\PinkCrab\Loader\Hook('my_filter', 'no_Callback_HERE');
        $hook->type(\pc_stock_man_v1\PinkCrab\Loader\Hook::FILTER);
        $manager = new \pc_stock_man_v1\PinkCrab\Loader\Hook_Manager();
        $manager->process_hook($hook);
    }
    /** @testdox When a valid remove hook is processed, it should be processed and the hook should be removed. */
    public function test_can_remove_hook() : void
    {
        add_action('remove_me_action', 'is_string');
        $hook = new \pc_stock_man_v1\PinkCrab\Loader\Hook('remove_me_action', 'is_string');
        $hook->type(\pc_stock_man_v1\PinkCrab\Loader\Hook::REMOVE);
        $manager = new \pc_stock_man_v1\PinkCrab\Loader\Hook_Manager();
        $manager->process_hook($hook);
        $this->assertFalse(has_action('remove_me_action'));
    }
    /** @testdox When an invalid callback is passed when registering an removal, an error should be thrown. */
    public function test_throws_exception_with_invlalid_remove_callback() : void
    {
        $this->expectException(\pc_stock_man_v1\PinkCrab\Loader\Exceptions\Invalid_Hook_Callback_Exception::class);
        $hook = new \pc_stock_man_v1\PinkCrab\Loader\Hook('remove_me_action', 'no_Callback_HERE');
        $hook->type(\pc_stock_man_v1\PinkCrab\Loader\Hook::REMOVE);
        $manager = new \pc_stock_man_v1\PinkCrab\Loader\Hook_Manager();
        $manager->process_hook($hook);
    }
    /**@testdox When a valid AJAX hook is processed, the underlying actons should be added based on the public/private settings. */
    public function test_can_register_ajax_call() : void
    {
        $hook_both = new \pc_stock_man_v1\PinkCrab\Loader\Hook('my_ajax_both', 'is_string');
        $hook_both->type(\pc_stock_man_v1\PinkCrab\Loader\Hook::AJAX);
        $hook_public_only = new \pc_stock_man_v1\PinkCrab\Loader\Hook('my_ajax_public', 'is_string');
        $hook_public_only->type(\pc_stock_man_v1\PinkCrab\Loader\Hook::AJAX);
        $hook_public_only->ajax_private(\false);
        $hook_private_only = new \pc_stock_man_v1\PinkCrab\Loader\Hook('my_ajax_private', 'is_string');
        $hook_private_only->type(\pc_stock_man_v1\PinkCrab\Loader\Hook::AJAX);
        $hook_private_only->ajax_public(\false);
        $hook_neither = new \pc_stock_man_v1\PinkCrab\Loader\Hook('my_ajax_neither', 'is_string');
        $hook_neither->type(\pc_stock_man_v1\PinkCrab\Loader\Hook::AJAX);
        $hook_neither->ajax_private(\false);
        $hook_neither->ajax_public(\false);
        $manager = new \pc_stock_man_v1\PinkCrab\Loader\Hook_Manager();
        $manager->process_hook($hook_both);
        $manager->process_hook($hook_public_only);
        $manager->process_hook($hook_private_only);
        $manager->process_hook($hook_neither);
        $this->assertTrue(has_action('wp_ajax_nopriv_' . 'my_ajax_both'));
        $this->assertTrue(has_action('wp_ajax_' . 'my_ajax_both'));
        $this->assertTrue(has_action('wp_ajax_nopriv_' . 'my_ajax_public'));
        $this->assertFalse(has_action('wp_ajax_' . 'my_ajax_public'));
        $this->assertFalse(has_action('wp_ajax_nopriv_' . 'my_ajax_private'));
        $this->assertTrue(has_action('wp_ajax_' . 'my_ajax_private'));
        $this->assertFalse(has_action('wp_ajax_nopriv_' . 'my_ajax_neither'));
        $this->assertFalse(has_action('wp_ajax_' . 'my_ajax_neither'));
    }
    /** @testdox When an invalid callback is passed when registering ajax, an error should be thrown. */
    public function test_throws_exception_with_invlalid_ajax_callback() : void
    {
        $this->expectException(\pc_stock_man_v1\PinkCrab\Loader\Exceptions\Invalid_Hook_Callback_Exception::class);
        $hook = new \pc_stock_man_v1\PinkCrab\Loader\Hook('remove_me_action', 'no_Callback_HERE');
        $hook->type(\pc_stock_man_v1\PinkCrab\Loader\Hook::AJAX);
        $manager = new \pc_stock_man_v1\PinkCrab\Loader\Hook_Manager();
        $manager->process_hook($hook);
    }
    /** @testdox When a valid Shortcode hook is processed, the tag and its callback should be registered with wp. */
    public function test_can_regster_shortcode() : void
    {
        $shortcode = new \pc_stock_man_v1\PinkCrab\Loader\Hook('my_shortcode', 'is_string');
        $shortcode->type(\pc_stock_man_v1\PinkCrab\Loader\Hook::SHORTCODE);
        $manager = new \pc_stock_man_v1\PinkCrab\Loader\Hook_Manager();
        $manager->process_hook($shortcode);
        $this->assertTrue(\shortcode_exists('my_shortcode'));
    }
    /** @testdox When an invalid callback is passed when registering shortcode, an error should be thrown. */
    public function test_throws_exception_with_invlalid_shortcode_callback() : void
    {
        $this->expectException(\pc_stock_man_v1\PinkCrab\Loader\Exceptions\Invalid_Hook_Callback_Exception::class);
        $hook = new \pc_stock_man_v1\PinkCrab\Loader\Hook('my_shortcode', 'no_Callback_HERE');
        $hook->type(\pc_stock_man_v1\PinkCrab\Loader\Hook::SHORTCODE);
        $manager = new \pc_stock_man_v1\PinkCrab\Loader\Hook_Manager();
        $manager->process_hook($hook);
    }
    /** @testdox When registering all hooks, the internal hook manager should be used unless otherwise defined. */
    public function test_can_use_custom_hook_manager() : void
    {
        $loader = new \pc_stock_man_v1\PinkCrab\Loader\Hook_Loader();
        $loader->filter('mock_action', 'is_string');
        $loader->register_hooks();
        $this->assertTrue(has_filter('mock_action'));
    }
}
