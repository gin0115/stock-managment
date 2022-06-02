<?php

declare (strict_types=1);
/**
 * Unit tests for the Ajax model and its helpers
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Ajax
 */
namespace PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Unit;

use PC_Woo_Stock_Man\WP_UnitTestCase;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax;
use PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Invalid_Ajax;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\CPT\Invlaid_CPT;
class Test_Ajax extends \WP_UnitTestCase
{
    /** @testdox It should be possible to get the wp_ajax action from an Ajax model. */
    public function test_can_get_action() : void
    {
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::ACTION, (new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax())->get_action());
    }
    /** @testdox Attempting to get the action on an Ajax model with no action defined should return null. */
    public function test_returns_null_if_no_action_defined() : void
    {
        $this->assertNull((new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Invalid_Ajax())->get_action());
    }
    /** @testdox It should be possible to get the wp_ajax nonce_handle from an Ajax model. */
    public function test_can_get_nonce_handle() : void
    {
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::NONCE_HANDLE, (new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax())->get_nonce_handle());
    }
    /** @testdox Attempting to get the nonce_handle on an Ajax model with no nonce_handle defined should return null. */
    public function test_returns_null_if_no_nonce_handle_defined() : void
    {
        $this->assertNull((new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Invalid_Ajax())->get_nonce_handle());
    }
    /** @testdox It should be possible to get the non field key from an Ajax model */
    public function test_can_get_nonce_field_key() : void
    {
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::NONCE_HANDLE, (new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax())->get_nonce_handle());
        // Fallback if not defined.
        $this->assertEquals('nonce', (new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Invalid_Ajax())->get_nonce_field());
    }
    /** @testdox It should be possible to get the logged in/out or prive/non_priv definitions from an ajax model. */
    public function test_can_get_priv_and_non_priv_settings() : void
    {
        $all_false = $this->createMock(\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax::class);
        \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::set_property($all_false, 'logged_in', \false);
        \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::set_property($all_false, 'logged_out', \false);
        $this->assertFalse($all_false->get_logged_in());
        $this->assertFalse($all_false->get_logged_out());
        $all_true = new \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax();
        $this->assertTrue($all_true->get_logged_in());
        $this->assertTrue($all_true->get_logged_out());
    }
}
