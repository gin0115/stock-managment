<?php

declare (strict_types=1);
/**
 * Intergration test for post type with defined post meta.
 *
 * @since 0.4.1
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Perique
 */
namespace pc_stock_man_v1\PinkCrab\Registerables\Tests\Application\Post_Type;

use pc_stock_man_v1\WP_UnitTestCase;
use pc_stock_man_v1\PinkCrab\Loader\Hook_Loader;
use pc_stock_man_v1\Gin0115\WPUnit_Helpers\WP\Meta_Data_Inspector;
use pc_stock_man_v1\PinkCrab\Registerables\Tests\App_Helper_Trait;
use pc_stock_man_v1\Gin0115\WPUnit_Helpers\WP\Entities\Meta_Data_Entity;
use pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT;
class Test_Meta_Data_CPT extends \WP_UnitTestCase
{
    use App_Helper_Trait;
    /**
     * Holds instance of the Post_Type object.
     *
     * @var \PinkCrab\Registerables\Post_Type
     */
    protected $cpt;
    /**
     * Holds all the current meta box global
     *
     * @var array
     */
    protected $wp_meta_boxes;
    /**
     * Holds the instance of the meta box inspector.
     *
     * @var Meta_Data_Inspector
     */
    protected $meta_data_inspector;
    /**
     * Reset the app data after each test.
     *
     * @return void
     */
    public function tearDown() : void
    {
        self::unset_app_instance();
    }
    public function setUp() : void
    {
        parent::setup();
        // Create the CPT and Loader instances.
        $this->cpt = new \pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT();
        self::create_with_registerables(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::class)->boot();
        do_action('init');
        // Build inspector.
        $this->meta_data_inspector = \pc_stock_man_v1\Gin0115\WPUnit_Helpers\WP\Meta_Data_Inspector::initialise();
    }
    /** @testdox When defining meta in the Post Types meta_data array, should see these meta values created within wp core, when we register the post type. */
    public function test_meta_data_registered() : void
    {
        // Check post type has 2 meta fields applied.
        $this->assertCount(2, $this->meta_data_inspector->for_post_types($this->cpt->key));
        // Meta 1 Values.
        $meta1 = $this->meta_data_inspector->find_post_meta($this->cpt->key, \pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_1['key']);
        $this->assertInstanceOf(\pc_stock_man_v1\Gin0115\WPUnit_Helpers\WP\Entities\Meta_Data_Entity::class, $meta1);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_1['type'], $meta1->value_type);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_1['key'], $meta1->meta_key);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_1['description'], $meta1->description);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_1['default'], $meta1->default);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_1['single'], $meta1->single);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_1['sanitize_callback'], $meta1->sanitize_callback);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_1['auth_callback'], $meta1->auth_callback);
        // Meta 2 Values.
        $meta2 = $this->meta_data_inspector->find_post_meta($this->cpt->key, \pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_2['key']);
        $this->assertInstanceOf(\pc_stock_man_v1\Gin0115\WPUnit_Helpers\WP\Entities\Meta_Data_Entity::class, $meta2);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_2['type'], $meta2->value_type);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_2['key'], $meta2->meta_key);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_2['description'], $meta2->description);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_2['default'], $meta2->default);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_2['single'], $meta2->single);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_2['sanitize_callback'], $meta2->sanitize_callback);
        $this->assertEquals(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\CPT\Meta_Data_CPT::META_2['auth_callback'], $meta2->auth_callback);
    }
}
