<?php

declare (strict_types=1);
/**
 * Unit tests for the Shared Meta Box Controller
 *
 * @since 0.7.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Perique
 */
namespace PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Unit\Metaboxes;

use PC_Woo_Stock_Man\WP_UnitTestCase;
use PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Box;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Shared_Meta_Box_Controller;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Registrar\Shared_Meta_Box_Registrar;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Shared_Metabox\Post_Page_Meta_Box;
class Test_Shared_Meta_Box_Controller extends \WP_UnitTestCase
{
    /** @testdox A populated Shared_Meta_Box_Controller should return a populated meta box */
    public function test_can_get_meta_box() : void
    {
        $meta_box = (new \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Shared_Metabox\Post_Page_Meta_Box())->meta_box();
        $this->assertInstanceof(\PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Box::class, $meta_box);
        $this->assertEquals('post_page_mb', $meta_box->key);
        $this->assertEquals('Post and Page Meta Box', $meta_box->label);
        $this->assertContains('post', $meta_box->screen);
        $this->assertContains('page', $meta_box->screen);
    }
    /** @testdox A populated Shared_Meta_Box_Controller should return an array of populated Meta Data. */
    public function test_can_get_meta_data() : void
    {
        $controller = new \PC_Woo_Stock_Man\PinkCrab\Registerables\Tests\Fixtures\Shared_Metabox\Post_Page_Meta_Box();
        $meta_data = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::invoke_method($controller, 'meta_data', array(array()));
        $this->assertCount(2, $meta_data);
        $this->assertInstanceOf(\PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data::class, $meta_data[0]);
        $this->assertStringContainsString('post', $meta_data[0]->get_meta_type());
        $this->assertStringContainsString('pnp_string', $meta_data[0]->get_meta_key());
        $this->assertInstanceOf(\PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data::class, $meta_data[1]);
        $this->assertStringContainsString('post', $meta_data[1]->get_meta_type());
        $this->assertStringContainsString('pnp_words', $meta_data[1]->get_meta_key());
    }
    /** @testdox If not meta data is supplied to the controller, it should return an empty array */
    public function test_meta_data_returns_empty_array_if_not_defined()
    {
        $controller = $this->createMock(\PC_Woo_Stock_Man\PinkCrab\Registerables\Shared_Meta_Box_Controller::class);
        $meta = $controller->meta_data(array());
        $this->assertIsArray($meta);
        $this->assertEmpty($meta);
    }
}
