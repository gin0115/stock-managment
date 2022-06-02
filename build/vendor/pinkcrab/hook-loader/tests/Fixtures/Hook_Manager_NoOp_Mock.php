<?php

declare (strict_types=1);
/**
 * Mock Hookmanager that does no hook registrations
 * Only updates the status to processed.
 *
 * @since 1.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Core
 */
namespace PC_Woo_Stock_Man\PinkCrab\Loader\Tests\Fixtures;

use PC_Woo_Stock_Man\PinkCrab\Loader\Hook;
use PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Manager;
class Hook_Manager_NoOp_Mock extends \PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Manager
{
    /** Toggles if or not the hooks should be marked as registered */
    public $registered_value = \true;
    /**
     * Callback used to process a hook
     */
    public function process_hook(\PC_Woo_Stock_Man\PinkCrab\Loader\Hook $hook) : \PC_Woo_Stock_Man\PinkCrab\Loader\Hook
    {
        $hook->registered($this->registered_value);
        return $hook;
    }
}
