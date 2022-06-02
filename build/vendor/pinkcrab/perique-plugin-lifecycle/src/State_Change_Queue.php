<?php

declare (strict_types=1);
/**
 * Queue and runner for a collection events
 *
 * @package PinkCrab\Plugin_Lifecycle
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */
namespace PC_Woo_Stock_Man\PinkCrab\Plugin_Lifecycle;

use PC_Woo_Stock_Man\PinkCrab\Plugin_Lifecycle\Plugin_State_Change;
use PC_Woo_Stock_Man\PinkCrab\Plugin_Lifecycle\State_Event\Activation;
class State_Change_Queue
{
    /**
     * Events
     *
     * @var Plugin_State_Change[]
     */
    protected $events;
    /** @param Plugin_State_Change ...$event */
    public function __construct(\PC_Woo_Stock_Man\PinkCrab\Plugin_Lifecycle\Plugin_State_Change ...$event)
    {
        $this->events = $event;
    }
    /**
     * Runs all of the queued events.
     *
     * @return void
     */
    public function __invoke()
    {
        foreach ($this->events as $event) {
            try {
                $event->run();
            } catch (\Throwable $th) {
                // If caught on Activation, throw Plugin_State_Exception
                if (\is_a($event, \PC_Woo_Stock_Man\PinkCrab\Plugin_Lifecycle\State_Event\Activation::class)) {
                    throw \PC_Woo_Stock_Man\PinkCrab\Plugin_Lifecycle\Plugin_State_Exception::error_running_state_change_event($event, $th);
                }
                continue;
            }
        }
    }
}
