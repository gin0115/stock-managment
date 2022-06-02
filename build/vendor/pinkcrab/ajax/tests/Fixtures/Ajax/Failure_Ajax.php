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

use Exception;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax;
use PC_Woo_Stock_Man\Psr\Http\Message\ResponseInterface;
use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Response_Factory;
class Failure_Ajax extends \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax
{
    public const ACTION = 'failure_action';
    public const NONCE_HANDLE = 'failure_nonce';
    public const NONCE_FIELD = 'failure_nonce_field';
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
        throw new \Exception("Exception thrown by: " . __CLASS__);
    }
    /**
     * Override the ajax handle
     *
     * @param string|null $handle
     * @return void
     */
    public function set_ajax_handle(?string $handle) : void
    {
        $this->nonce_handle = $handle;
    }
}
