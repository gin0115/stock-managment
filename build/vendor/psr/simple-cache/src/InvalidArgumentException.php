<?php

namespace PC_Woo_Stock_Man\Psr\SimpleCache;

/**
 * Exception interface for invalid cache arguments.
 *
 * When an invalid argument is passed it must throw an exception which implements
 * this interface
 */
interface InvalidArgumentException extends \PC_Woo_Stock_Man\Psr\SimpleCache\CacheException
{
}
