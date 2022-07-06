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
namespace pc_stock_man_v1\PinkCrab\Loader\Tests\Fixtures;

use pc_stock_man_v1\PinkCrab\Loader\Hook;
use pc_stock_man_v1\PinkCrab\Loader\Hook_Manager;
class Hook_Manager_NoOp_Mock extends \pc_stock_man_v1\PinkCrab\Loader\Hook_Manager
{
    /** Toggles if or not the hooks should be marked as registered */
    public $registered_value = \true;
    /**
     * Callback used to process a hook
     */
    public function process_hook(\pc_stock_man_v1\PinkCrab\Loader\Hook $hook) : \pc_stock_man_v1\PinkCrab\Loader\Hook
    {
        $hook->registered($this->registered_value);
        return $hook;
    }
}
