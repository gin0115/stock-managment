<?php

declare (strict_types=1);
/**
 * Invalid cpt
 *
 * @since 0.2.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Registerables
 */
namespace pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT;

use pc_stock_man_v1\PinkCrab\Registerables\Post_Type;
class Invlaid_CPT extends \pc_stock_man_v1\PinkCrab\Registerables\Post_Type
{
    public $key = null;
    public $singular = null;
    public $plural = null;
}
