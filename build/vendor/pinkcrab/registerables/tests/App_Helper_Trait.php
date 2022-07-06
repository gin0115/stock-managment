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
namespace pc_stock_man_v1\PinkCrab\Registerables\Tests;

use pc_stock_man_v1\PinkCrab\Perique\Application\App;
use pc_stock_man_v1\PinkCrab\Perique\Services\View\View;
use pc_stock_man_v1\PinkCrab\Registerables\Registration_Middleware\Registerable_Middleware;
use pc_stock_man_v1\PinkCrab\Loader\Hook_Loader;
use pc_stock_man_v1\Dice\Dice;
use pc_stock_man_v1\PinkCrab\Perique\Services\Dice\PinkCrab_Dice;
use pc_stock_man_v1\PinkCrab\Perique\Services\Registration\Registration_Service;
use pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects;
use pc_stock_man_v1\PinkCrab\Perique\Interfaces\Renderable;
use pc_stock_man_v1\PinkCrab\Perique\Services\View\PHP_Engine;
trait App_Helper_Trait
{
    /**
     * Resets the any existing App instance with default properties.
     *
     * @return void
     */
    protected static function unset_app_instance() : void
    {
        $app = new \pc_stock_man_v1\PinkCrab\Perique\Application\App();
        \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'app_config', null);
        \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'container', null);
        \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'registration', null);
        \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'loader', null);
        \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'booted', \false);
        $app = null;
    }
    protected static function create_with_registerables(string ...$class) : \pc_stock_man_v1\PinkCrab\Perique\Application\App
    {
        // Build and populate the app.
        $app = new \pc_stock_man_v1\PinkCrab\Perique\Application\App();
        $registration = new \pc_stock_man_v1\PinkCrab\Perique\Services\Registration\Registration_Service();
        $container = new \pc_stock_man_v1\PinkCrab\Perique\Services\Dice\PinkCrab_Dice(new \pc_stock_man_v1\Dice\Dice());
        $loader = new \pc_stock_man_v1\PinkCrab\Loader\Hook_Loader();
        $app->set_container($container);
        $app->set_registration_services($registration);
        $app->set_loader($loader);
        $app->construct_registration_middleware(\pc_stock_man_v1\PinkCrab\Registerables\Registration_Middleware\Registerable_Middleware::class);
        if (!empty($class)) {
            $app->registration_classes($class);
        }
        $app->set_app_config(array());
        $container->addRules(array('*' => array('substitutions' => array(\pc_stock_man_v1\PinkCrab\Perique\Interfaces\Renderable::class => new \pc_stock_man_v1\PinkCrab\Perique\Services\View\PHP_Engine(\FIXTURES . '/Views')))));
        return $app;
    }
}
