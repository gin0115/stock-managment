<?php

declare(strict_types=1);

/**
 * Repository for WP Options.
 * 
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace PinkCrab\Stock_Management\WP_Repository;

class Options_Repository{

    /**
     * Gets a value based on its key with a definable fallback
     *
     * @param string $key
     * @param string|int|float|bool|object|mixed[]|null $default
     * @return string|int|float|bool|object|mixed[]|null
     */
    public function get(string $key, $default = false)
    {
        return get_option($key, $default);
    }

    /**
     * Sets a value with a defined key that is auto loaded on 'init'
     *
     * @param string $key
     * @param string|int|float|bool|object|mixed[]|null $value
     * @return bool
     */
    public function set_as_autoloaded(string $key, $value): bool
    {
        return \update_option($key, $value, true);
    }

    /**
     * Sets a value with a defined key that is NOT autloaded on 'init;
     *
     * @param string $key
     * @param string|int|float|bool|object|mixed[]|null $value
     * @return bool
     */
    public function set_as_not_autoloaded(string $key, $value): bool
    {
        return \update_option($key, $value, false);
    }

    /**
     * Clears the current value by setting as false and not
     * autoloading on init.
     *
     * @param string $key
     * @return bool
     */
    public function clear(string $key): bool
    {
        return $this->set_as_not_autoloaded($key, false);
    }

    /**
     * Deletes and existing option based on its key
     *
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool
    {
        return \delete_option($key);
    }
}