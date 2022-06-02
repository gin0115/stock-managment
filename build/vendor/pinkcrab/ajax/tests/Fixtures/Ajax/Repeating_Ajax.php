<?php

declare (strict_types=1);
/**
 * Mock Ajax class that returns the request body as its responce
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Ajax
 */
namespace PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax;

use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Response_Factory;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper;
use PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface;
class Repeating_Ajax extends \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax
{
    public const ACTION = 'repeating_ajax_action';
    /**
     * Define the action to call.
     * @var string
     */
    protected $action = self::ACTION;
    /**
     * The callback
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \PinkCrab\Ajax\Dispatcher\Response_Factory $response_factory
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function callback(\PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface $request, \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Response_Factory $response_factory) : \PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface
    {
        return $response_factory->success(\PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Helper::extract_server_request_args($request));
    }
}
