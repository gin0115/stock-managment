<?php

declare (strict_types=1);
/**
 * Helper trait for all App tests
 * Includes clearing the internal state of an existing instance.
 *
 * @since 0.4.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Registerables
 */
namespace PC_Woo_Stock_Man\PinkCrab\Registerables\Tests;

use PC_Woo_Stock_Man\PinkCrab\Perique\Application\App;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\View;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Registration_Middleware\Registerable_Middleware;
use PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader;
use PC_Woo_Stock_Man\Dice\Dice;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\Dice\PinkCrab_Dice;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\Registration\Registration_Service;
use PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects;
use PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\Renderable;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\PHP_Engine;
trait App_Helper_Trait
{
    /**
     * Resets the any existing App instance with default properties.
     *
     * @return void
     */
    protected static function unset_app_instance() : void
    {
        $app = new \PC_Woo_Stock_Man\PinkCrab\Perique\Application\App();
        \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'app_config', null);
        \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'container', null);
        \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'registration', null);
        \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'loader', null);
        \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'booted', \false);
        $app = null;
    }
    protected static function create_with_registerables(string ...$class) : \PC_Woo_Stock_Man\PinkCrab\Perique\Application\App
    {
        // Build and populate the app.
        $app = new \PC_Woo_Stock_Man\PinkCrab\Perique\Application\App();
        $registration = new \PC_Woo_Stock_Man\PinkCrab\Perique\Services\Registration\Registration_Service();
        $container = new \PC_Woo_Stock_Man\PinkCrab\Perique\Services\Dice\PinkCrab_Dice(new \PC_Woo_Stock_Man\Dice\Dice());
        $loader = new \PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader();
        $app->set_container($container);
        $app->set_registration_services($registration);
        $app->set_loader($loader);
        $app->construct_registration_middleware(\PC_Woo_Stock_Man\PinkCrab\Registerables\Registration_Middleware\Registerable_Middleware::class);
        if (!empty($class)) {
            $app->registration_classes($class);
        }
        $app->set_app_config(array());
        $container->addRules(array('*' => array('substitutions' => array(\PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\Renderable::class => new \PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\PHP_Engine(\FIXTURES . '/Views')))));
        return $app;
    }
}
