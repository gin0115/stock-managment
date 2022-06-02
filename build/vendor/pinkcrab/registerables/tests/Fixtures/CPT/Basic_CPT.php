<?php

declare (strict_types=1);
/**
 * Basic CPT Mock Object
 *
 * @since 0.2.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Registerables
 */
namespace PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\CPT;

use PC_Woo_Stock_Man\PinkCrab\Registerables\Post_Type;
class Basic_CPT extends \PC_Woo_Stock_Man\PinkCrab\Registerables\Post_Type
{
    public $key = 'basic_cpt';
    public $singular = 'Basic';
    public $plural = 'Basics';
    public $gutenberg = \true;
    public $map_meta_cap = \true;
}
