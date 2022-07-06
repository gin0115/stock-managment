<?php

declare (strict_types=1);
/**
 * String Argument type.
 *
 * @package PinkCrab\WP_Rest_Schema
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.1.0
 */
namespace pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument;

use pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument;
class String_Type extends \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument
{
    public function __construct(string $key)
    {
        parent::__construct($key);
        $this->type(\pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument::TYPE_STRING);
    }
    /**
     * Sets the min length of the value
     *
     * @param int $min
     * @return static
     */
    public function min_length(int $min) : self
    {
        return $this->add_attribute('minLength', $min);
    }
    /**
     * Gets the set min length, returns null if not set.
     *
     * @return int|null
     */
    public function get_min_length() : ?int
    {
        return $this->get_attribute('minLength');
    }
    /**
     * Sets the max length of the value
     *
     * @param int $max
     * @return static
     */
    public function max_length(int $max) : self
    {
        return $this->add_attribute('maxLength', $max);
    }
    /**
     * Gets the set max length, returns null if not set.
     *
     * @return int|null
     */
    public function get_max_length() : ?int
    {
        return $this->get_attribute('maxLength');
    }
    /**
     * Sets the pattern to validate
     *
     * @param string $pattern
     * @return static
     */
    public function pattern(string $pattern) : self
    {
        return $this->add_attribute('pattern', $pattern);
    }
    /**
     * Gets the set pattern, returns null if not set.
     *
     * @return string|null
     */
    public function get_pattern() : ?string
    {
        return $this->get_attribute('pattern');
    }
}
