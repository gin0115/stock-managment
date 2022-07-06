<?php

declare (strict_types=1);
/**
 * Interface for all classes which are run at plugin Deactivation.
 *
 * @package PinkCrab\Plugin_Lifecycle
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */
namespace pc_stock_man_v1\PinkCrab\Plugin_Lifecycle\State_Event;

use pc_stock_man_v1\PinkCrab\Plugin_Lifecycle\Plugin_State_Change;
interface Deactivation extends \pc_stock_man_v1\PinkCrab\Plugin_Lifecycle\Plugin_State_Change
{
}
