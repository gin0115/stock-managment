<?php

declare (strict_types=1);
/**
 * Basic simple, Hierarchical taxonomy.
 *
 * @since 0.2.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Registerables
 */
namespace PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Taxonomies;

use PC_Woo_Stock_Man\PinkCrab\Registerables\Taxonomy;
class Basic_Hierarchical_Taxonomy extends \PC_Woo_Stock_Man\PinkCrab\Registerables\Taxonomy
{
    public $slug = 'basic_hier_tax';
    public $singular = 'Basic Hier Taxonomy';
    public $plural = 'Basic Hier Taxonomies';
    public $description = 'The Basic Hier Taxonomy.';
    public $hierarchical = \true;
    public $object_type = array('basic_cpt', 'page');
    public $public = \false;
    public $show_ui = \false;
    public $show_in_menu = \false;
    public $show_admin_column = \false;
    public $show_tagcloud = \false;
    public $show_in_quick_edit = \false;
}
