<?php

declare (strict_types=1);
/**
 * Intergration tests of using Registration Middleware with live app.
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Ajax
 */
namespace PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Intergration;

use Exception;
use PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP_Helper;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Bootstrap;
use PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects;
use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface;
use PC_Woo_Stock_Man\PinkCrab\Perique\Application\App_Factory;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax_BaseCase;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Invalid_Ajax;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Repeating_Ajax;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Registration_Middleware\Ajax_Middleware;
class Test_App_Instance extends \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax_BaseCase
{
    /** @testdox It should be possible to add the Ajax Dispatcher in as Registration Middleware as part of the Prique Framework. You then should be able to just add Ajax Models to the Registration list used for the internal Registeration system.  */
    public function test_app_instance() : void
    {
        // Bootstrap with Perique
        \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Bootstrap::use();
        // Construct the app
        $app = (new \PC_Woo_Stock_Man\PinkCrab\Perique\Application\App_Factory())->with_wp_dice(\true)->app_config(array())->di_rules(array())->registration_classes(array(\PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Has_Nonce_Ajax::class, \PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax\Repeating_Ajax::class))->boot();
        // Add the custom middleware
        $middleware = $app::make(\PC_Woo_Stock_Man\PinkCrab\Ajax\Registration_Middleware\Ajax_Middleware::class);
        $app->registration_middleware($middleware);
        // Trigger app intialisation
        do_action('init');
        // Extract the hooks from the dispatcher, from middleware
        $dispatcher = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($middleware, 'dispatcher');
        $hook_loader = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($dispatcher, 'loader');
        $hooks = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($hook_loader, 'hooks');
        $hooks = $hooks->export();
        // Check ajax calls are registered.
        $this->assertTrue($hooks[0]->is_registered());
        $this->assertTrue(\has_action('wp_ajax_' . $hooks[0]->get_handle()));
        $this->assertTrue($hooks[1]->is_registered());
        $this->assertTrue(\has_action('wp_ajax_' . $hooks[1]->get_handle()));
    }
}
