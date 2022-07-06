<?php

declare (strict_types=1);
/**
 * Helpers for generating child arguments.
 *
 * @package PinkCrab\WP_Rest_Schema
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.1.0
 */
namespace pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Attribute;

use pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument;
use pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Null_Type;
use pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Array_Type;
use pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Number_Type;
use pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Object_Type;
use pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\String_Type;
use pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Boolean_Type;
use pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Integer_Type;
trait Children
{
    /**
     * Returns an array of all valid argument types.
     *
     * @return array<string, class-string<Argument>>
     */
    protected function type_map() : array
    {
        return array(\pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument::TYPE_ARRAY => \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Array_Type::class, \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument::TYPE_BOOLEAN => \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Boolean_Type::class, \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument::TYPE_INTEGER => \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Integer_Type::class, \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument::TYPE_NUMBER => \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Number_Type::class, \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument::TYPE_OBJECT => \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Object_Type::class, \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument::TYPE_STRING => \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\String_Type::class, \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument::TYPE_NULL => \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Null_Type::class);
    }
    /**
     * Creates a child from the current Argument.
     *
     * @param string $reference
     * @param string $type
     * @return \PinkCrab\WP_Rest_Schema\Argument\Argument
     * @throws \Exception If applied to a none Argument Class or invalid type.
     *
     */
    protected function create_child(string $reference, string $type) : \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument
    {
        // Can only be called from an Argument parent class.
        if (!\is_a($this, \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument::class)) {
            throw new \Exception('Only classes that extend Argument can create children types', 300);
        }
        if (!\in_array($type, \array_keys($this->type_map()), \true)) {
            throw new \Exception("{$type} is not a valid argument type.", 301);
        }
        $key = "{$this->get_key()}_{$reference}";
        $class = $this->type_map()[$type];
        return new $class($key);
    }
}
