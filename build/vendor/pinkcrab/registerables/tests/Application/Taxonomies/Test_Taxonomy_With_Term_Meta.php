<?php

declare (strict_types=1);
/**
 * Tests taxonomies with default terms and term meta.
 *
 * @since 0.4.1
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Perique
 */
namespace PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Application\Taxonomies;

use PC_Woo_Stock_Man\WP_UnitTestCase;
use PC_Woo_Stock_Man\PinkCrab\Loader\Hook_Loader;
use PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\WP\Meta_Data_Inspector;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\App_Helper_Trait;
use PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\WP\Entities\Meta_Data_Entity;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Taxonomies\Tag_With_Meta_Taxonomy;
class Test_Taxonomy_With_Term_Meta extends \WP_UnitTestCase
{
    use App_Helper_Trait;
    /** @return array<\WP_Taxonomy> */
    protected $taxonomy;
    /** @var Meta_Data_Inspector */
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
        $this->taxonomy = new \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Taxonomies\Tag_With_Meta_Taxonomy();
        self::create_with_registerables(\PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Taxonomies\Tag_With_Meta_Taxonomy::class)->boot();
        do_action('init');
        // Build inspector.
        $this->meta_data_inspector = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\WP\Meta_Data_Inspector::initialise();
    }
    /** @return array<\WP_Term> */
    protected function get_terms() : array
    {
        return get_terms(array('taxonomy' => $this->taxonomy->slug, 'hide_empty' => \false));
    }
    /** @testdox It should be possible to set a default term and have it created when the taxonomy is registered. */
    public function test_default_term() : void
    {
        $this->assertNotEmpty(\array_filter($this->get_terms(), function (\WP_Term $term) : bool {
            return $term->slug === \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Taxonomies\Tag_With_Meta_Taxonomy::DEFAULT_TERM_SLUG;
        }));
    }
    /** @testdox It should be possible to set term meta when defining a taxonomy. */
    public function test_can_set_term_meta() : void
    {
        $terms = $this->get_terms();
        $term_id = $terms[0]->term_id;
        // Check default values.
        $meta1 = get_term_meta($term_id, \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Taxonomies\Tag_With_Meta_Taxonomy::META_1['key'], \true);
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Taxonomies\Tag_With_Meta_Taxonomy::META_1['default'], $meta1);
        $meta2 = get_term_meta($term_id, \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Taxonomies\Tag_With_Meta_Taxonomy::META_2['key'], \true);
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Taxonomies\Tag_With_Meta_Taxonomy::META_2['default'], $meta2);
    }
    /** @testdox When defining meta in the Taxonomies, term meta_data array, should see these meta values created within wp core, when we register the taxonomy. */
    public function test_meta_data_registered_taxonomy() : void
    {
        // Check post type has 2 meta fields applied.
        $this->assertCount(2, $this->meta_data_inspector->for_taxonomies($this->taxonomy->slug));
        // Meta 1 Values.
        $meta1 = $this->meta_data_inspector->find_term_meta($this->taxonomy->slug, \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Taxonomies\Tag_With_Meta_Taxonomy::META_1['key']);
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\WP\Entities\Meta_Data_Entity::class, $meta1);
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Taxonomies\Tag_With_Meta_Taxonomy::meta_rest_key_1_schema(), $meta1->show_in_rest);
        // Meta 2 Values.
        $meta2 = $this->meta_data_inspector->find_term_meta($this->taxonomy->slug, \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Taxonomies\Tag_With_Meta_Taxonomy::META_2['key']);
        $this->assertInstanceOf(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\WP\Entities\Meta_Data_Entity::class, $meta2);
        $this->assertEquals(\PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Taxonomies\Tag_With_Meta_Taxonomy::meta_rest_key_2_schema_as_array(), $meta2->show_in_rest);
    }
}
