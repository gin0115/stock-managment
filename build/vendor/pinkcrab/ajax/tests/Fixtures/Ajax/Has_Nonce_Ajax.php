<?php

declare (strict_types=1);
/**
 * Mock Ajax call for a simple GET
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Ajax
 */
namespace PC_Woo_Stock_Man\PinkCrab\Ajax\Tests\Fixtures\Ajax;

use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax;
use PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Response_Factory;
use PC_Woo_Stock_Man\Psr\Http\Message\ResponseFactoryInterface;
class Has_Nonce_Ajax extends \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax
{
    public const ACTION = 'logged_in_out_action';
    public const NONCE_HANDLE = 'logged_in_out_nonce';
    public const NONCE_FIELD = 'logged_in_out_nonce_field';
    /**
     * Define the action to call.
     * @var string
     */
    protected $action = self::ACTION;
    /**
     * The ajax calls nonce handle.
     * @var string
     */
    protected $nonce_handle = self::NONCE_HANDLE;
    /**
     * The nonce field
     * @var string
     */
    protected $nonce_field = self::NONCE_FIELD;
    /**
     * The callback
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \PinkCrab\Ajax\Dispatcher\Response_Factory $response_factory
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function callback(\PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface $request, \PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Response_Factory $response_factory) : \PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface
    {
        return $response_factory->success(array('success' => __CLASS__, 'get' => $request->getQueryParams()));
    }
}
