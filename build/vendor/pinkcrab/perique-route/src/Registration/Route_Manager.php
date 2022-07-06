<?php

declare (strict_types=1);
/**
 * Handle the parsing and registering of route with WordPress.
 *
 * @package PinkCrab\Route\Route
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */
namespace pc_stock_man_v1\PinkCrab\Route\Registration;

use pc_stock_man_v1\PinkCrab\Route\Route\Route;
use pc_stock_man_v1\PinkCrab\Loader\Hook_Loader;
use pc_stock_man_v1\PinkCrab\Route\Route\Route_Group;
use pc_stock_man_v1\PinkCrab\Route\Registration\WP_Rest_Registrar;
use pc_stock_man_v1\PinkCrab\Route\Route_Exception;
class Route_Manager
{
    /** @var Hook_Loader */
    protected $loader;
    /** @var WP_Rest_Registrar */
    protected $registrar;
    public function __construct(\pc_stock_man_v1\PinkCrab\Route\Registration\WP_Rest_Registrar $registrar, \pc_stock_man_v1\PinkCrab\Loader\Hook_Loader $hook_loader)
    {
        $this->loader = $hook_loader;
        $this->registrar = $registrar;
    }
    /**
     * Registers a WP Rest Route from a passed Route model.
     *
     * @param Route $route
     * @return self
     */
    public function from_route(\pc_stock_man_v1\PinkCrab\Route\Route\Route $route) : self
    {
        $this->loader->action('rest_api_init', $this->registrar->create_callback($route));
        return $this;
    }
    /**
     * Registers all routes from a group.
     *
     * @param \PinkCrab\Route\Route\Route_Group $group
     * @return self
     */
    public function from_group(\pc_stock_man_v1\PinkCrab\Route\Route\Route_Group $group) : self
    {
        foreach ($this->unpack_group($group) as $route) {
            $this->from_route($route);
        }
        return $this;
    }
    /**
     * Unpacks a group into its routes with all shared (Auth & Argument) properties from the group
     *
     * @param \PinkCrab\Route\Route\Route_Group $group
     * @return Route[]
     * @throws Route_Exception code 102
     */
    protected function unpack_group(\pc_stock_man_v1\PinkCrab\Route\Route\Route_Group $group) : array
    {
        $routes = array();
        // Loop through each group
        foreach ($group->get_rest_routes() as $method => $route) {
            $populated_route = $this->create_base_route_from_group($method, $group);
            // Replace args if set.
            foreach ($route->get_arguments() as $key => $argument) {
                $populated_route->argument($argument);
            }
            // Extends any group based authentication with a route based.
            foreach ($route->get_authentication() as $key => $auth_callback) {
                $populated_route->authentication($auth_callback);
            }
            // If we have no callback defined for route, throw.
            if (\is_null($route->get_callback())) {
                throw \pc_stock_man_v1\PinkCrab\Route\Route_Exception::callback_not_defined($route);
            }
            $populated_route->callback($route->get_callback());
            $routes[$method] = $populated_route;
        }
        return $routes;
    }
    /**
     * Generates a base route from a group for a defined method.
     * Populates the groups namespace, authentication and arguemnts
     * as inital values on the route.
     *
     * @param string $method
     * @param Route_Group $group
     * @return Route
     */
    protected function create_base_route_from_group(string $method, \pc_stock_man_v1\PinkCrab\Route\Route\Route_Group $group) : \pc_stock_man_v1\PinkCrab\Route\Route\Route
    {
        $route = new \pc_stock_man_v1\PinkCrab\Route\Route\Route(\strtoupper($method), $group->get_route());
        $route->namespace($group->get_namespace());
        foreach ($group->get_authentication() as $auth_callback) {
            $route->authentication($auth_callback);
        }
        foreach ($group->get_arguments() as $argument) {
            $route->argument($argument);
        }
        return $route;
    }
    /**
     * Registers all routes added to the loader
     *
     * @return void
     */
    public function execute() : void
    {
        $this->loader->register_hooks();
    }
}
