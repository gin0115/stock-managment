<?php

declare (strict_types=1);
/**
 * Interface for all classes which are run at plugin Uninstall.
 *
 * @package PinkCrab\Plugin_Lifecycle
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */
namespace PC_Woo_Stock_Man\PinkCrab\Plugin_Lifecycle\State_Event;

use PC_Woo_Stock_Man\PinkCrab\Plugin_Lifecycle\Plugin_State_Change;
interface Uninstall extends \PC_Woo_Stock_Man\PinkCrab\Plugin_Lifecycle\Plugin_State_Change
{
}
