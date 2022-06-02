<?php

declare (strict_types=1);
/**
 * Ajax Dispatcher Middleware
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Ajax
 */
namespace PC_Woo_Stock_Man\PinkCrab\Ajax\Registration_Middleware;

use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Dispatcher;
use PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\Registration_Middleware;
class Ajax_Middleware implements \PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\Registration_Middleware
{
    /** @var Ajax_Dispatcher */
    public $dispatcher;
    public function __construct(\PC_Woo_Stock_Man\PinkCrab\Ajax\Dispatcher\Ajax_Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    /**
     * Add all valid ajax calls to the dispatcher.
     *
     * @param object $class
     * @return object
     */
    public function process($class)
    {
        if (\is_a($class, \PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax::class) && is_admin() && (!\defined('DOING_AJAX') || !DOING_AJAX)) {
            $this->dispatcher->add_ajax_call($class);
        }
        return $class;
    }
    public function setup() : void
    {
        /*noOp*/
    }
    /**
     * Register all ajax calls.
     *
     * @return void
     */
    public function tear_down() : void
    {
        $this->dispatcher->execute();
    }
}
