<?php

declare (strict_types=1);
/**
 * Base class for Ajax Intergration tests.
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Ajax
 */
namespace PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures;

use PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Controller;
use PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Dispatcher;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Request_Validator;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Response_Factory;
use PC_Woo_Stock_Man\WP_Ajax_UnitTestCase;
abstract class Ajax_BaseCase extends \WP_Ajax_UnitTestCase
{
    /**
     * Retruns a populated instance of the Ajax Dispatcher
     *
     * @return Ajax_Dispatcher
     */
    protected function ajax_dispatcher_provider(?callable $request_config = null) : \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Dispatcher
    {
        $http_helper = new \PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP();
        $server_request = $request_config ? $request_config($http_helper->request_from_globals()) : $http_helper->request_from_globals();
        $controller = new \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Controller($server_request, new \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Response_Factory($http_helper), $http_helper, new \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Request_Validator($server_request));
        return new \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Dispatcher($controller);
    }
}
