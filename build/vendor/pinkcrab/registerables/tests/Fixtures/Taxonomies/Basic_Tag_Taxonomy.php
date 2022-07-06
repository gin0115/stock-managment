<?php

declare (strict_types=1);
/**
 * Basic simple, flat taxonomy.
 *
 * @since 0.2.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Registerables
 */
namespace pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\Taxonomies;

use pc_stock_man_v1\PinkCrab\Registerables\Taxonomy;
class Basic_Tag_Taxonomy extends \pc_stock_man_v1\PinkCrab\Registerables\Taxonomy
{
    public $slug = 'basic_tag_tax';
    public $singular = 'Basic Tag Taxonomy';
    public $plural = 'Basic Tag Taxonomies';
    public $description = 'The Basic Tag Taxonomy.';
    public $hierarchical = \false;
    public $object_type = array('basic_cpt');
}
