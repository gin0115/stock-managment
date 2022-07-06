<?php

declare (strict_types=1);
/**
 * Registers routes through WP API from Route mooels.
 *
 * @package PinkCrab\Route\Route
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */
namespace pc_stock_man_v1\PinkCrab\Route\Registration;

use pc_stock_man_v1\PinkCrab\Route\Utils;
use pc_stock_man_v1\PinkCrab\Route\Route\Route;
use pc_stock_man_v1\PinkCrab\Route\Route_Exception;
use pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument;
use pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Parser\Argument_Parser;
class WP_Rest_Registrar
{
    /**
     * The register wp rest callback.
     *
     * @param \PinkCrab\Route\Route\Route $route
     * @return callable
     */
    public function create_callback(\pc_stock_man_v1\PinkCrab\Route\Route\Route $route) : callable
    {
        return function () use($route) : void {
            $model = $this->map_to_wp_rest($route);
            register_rest_route($model->namespace, $model->route, $model->args);
        };
    }
    /**
     * Maps a wp rest model from Route.
     *
     * @param \PinkCrab\Route\Route\Route $route
     * @return WP_Rest_Route
     */
    public function map_to_wp_rest(\pc_stock_man_v1\PinkCrab\Route\Route\Route $route) : \pc_stock_man_v1\PinkCrab\Route\Registration\WP_Rest_Route
    {
        $wp_rest = new \pc_stock_man_v1\PinkCrab\Route\Registration\WP_Rest_Route();
        $wp_rest->namespace = $route->get_namespace();
        $wp_rest->route = $route->get_route();
        $wp_rest->args = $this->parse_options($route);
        return $wp_rest;
    }
    /**
     * Parsed the args array used to register.
     *
     * @param Route $route
     * @return array<mixed>
     * @throws Route_Exception
     */
    protected function parse_options(\pc_stock_man_v1\PinkCrab\Route\Route\Route $route) : array
    {
        // If we have no callback defined for route, throw.
        if (\is_null($route->get_callback())) {
            throw \pc_stock_man_v1\PinkCrab\Route\Route_Exception::callback_not_defined($route);
        }
        // If we have an invlaid method, throw
        if (!$this->is_valid_method($route->get_method())) {
            throw \pc_stock_man_v1\PinkCrab\Route\Route_Exception::invalid_http_method($route);
        }
        $options = array();
        $options['methods'] = $route->get_method();
        $options['callback'] = $route->get_callback();
        $options['permission_callback'] = $this->compose_permission_callback($route);
        $options['args'] = $this->parse_args($route);
        return $options;
    }
    /**
     * Parsed the args array of options.
     *
     * @param Route $route
     * @return array<mixed>
     */
    protected function parse_args(\pc_stock_man_v1\PinkCrab\Route\Route\Route $route) : array
    {
        return \array_reduce($route->get_arguments(), function (array $args, \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument $argument) {
            $args[$argument->get_key()] = \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Parser\Argument_Parser::as_single($argument);
            return $args;
        }, array());
    }
    /**
     * Checks if a defined HTTP method is valid.
     *
     * @param string $method
     * @return boolean
     */
    protected function is_valid_method(string $method) : bool
    {
        return \in_array($method, apply_filters(
            'pinkcrab/route/accepted_http_methods',
            // phpcs:ignore WordPress.NamingConventions.ValidHookName
            array(\pc_stock_man_v1\PinkCrab\Route\Route\Route::DELETE, \pc_stock_man_v1\PinkCrab\Route\Route\Route::POST, \pc_stock_man_v1\PinkCrab\Route\Route\Route::PUT, \pc_stock_man_v1\PinkCrab\Route\Route\Route::PATCH, \pc_stock_man_v1\PinkCrab\Route\Route\Route::GET)
        ), \true);
    }
    /**
     * Compose the permission callback function for the route.
     *
     * @param Route $route
     * @return callable
     */
    protected function compose_permission_callback(\pc_stock_man_v1\PinkCrab\Route\Route\Route $route) : callable
    {
        $callbacks = $route->get_authentication();
        // If we have no callback defined, use return true.
        if (\count($callbacks) === 0) {
            return '__return_true';
        }
        // If we only have 1, return as is.
        if (\count($callbacks) === 1) {
            return $callbacks[0];
        }
        return \pc_stock_man_v1\PinkCrab\Route\Utils::compose_conditional_all_true(...$callbacks);
    }
}
