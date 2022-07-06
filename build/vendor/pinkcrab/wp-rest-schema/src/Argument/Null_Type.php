<?php

declare (strict_types=1);
/**
 * Null Argument type.
 *
 * @package PinkCrab\WP_Rest_Schema
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.1.0
 */
namespace pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument;

use pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument;
class Null_Type extends \pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument
{
    public function __construct(string $key)
    {
        parent::__construct($key);
        $this->type(\pc_stock_man_v1\PinkCrab\WP_Rest_Schema\Argument\Argument::TYPE_NULL);
    }
}
