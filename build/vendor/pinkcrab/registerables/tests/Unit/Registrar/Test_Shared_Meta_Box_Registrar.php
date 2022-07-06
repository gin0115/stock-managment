<?php

declare (strict_types=1);
/**
 * Unit tests for the Shared Meta Box registrar
 *
 * @since 0.7.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Registerables
 */
namespace pc_stock_man_v1\PinkCrab\Registerables\Tests\Unit\Registrar;

use Exception;
use PHPUnit\Framework\TestCase;
use pc_stock_man_v1\PinkCrab\Loader\Hook_Loader;
use pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects;
use pc_stock_man_v1\PinkCrab\Registerables\Meta_Box;
use pc_stock_man_v1\PinkCrab\Registerables\Meta_Data;
use pc_stock_man_v1\PinkCrab\Perique\Services\View\View;
use pc_stock_man_v1\PinkCrab\Perique\Interfaces\DI_Container;
use pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Box_Registrar;
use pc_stock_man_v1\PinkCrab\Registerables\Validator\Meta_Box_Validator;
use pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Data_Registrar;
use pc_stock_man_v1\PinkCrab\Registerables\Registrar\Shared_Meta_Box_Registrar;
use pc_stock_man_v1\PinkCrab\Registerables\Registration_Middleware\Registerable;
use pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\Shared_Metabox\Post_Page_Meta_Box;
class Test_Shared_Meta_Box_Registrar extends \PHPUnit\Framework\TestCase
{
    /** @testdox Attempting to pass a none shared meta box controller to the registrar should skip the class */
    public function test_skips_none_shared_meta_boxes() : void
    {
        $registered = \false;
        $mb_registrar = $this->createMock(\pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Box_Registrar::class);
        $md_registrar = $this->createMock(\pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Data_Registrar::class);
        $mb_registrar->method('register')->with()->will($this->returnCallback(function ($meta_box) use(&$registered) {
            $registered = \true;
        }));
        $registrar = new \pc_stock_man_v1\PinkCrab\Registerables\Registrar\Shared_Meta_Box_Registrar($mb_registrar, $md_registrar);
        $registrar->register($this->createMock(\pc_stock_man_v1\PinkCrab\Registerables\Registration_Middleware\Registerable::class));
        $this->assertFalse($registered);
        // $registrar->register( new Post_Page_Meta_Box );
    }
    /** @testdox Passing a valid shared meta box controller to the registrar should register it. */
    public function test_registers_shared_meta_boxes() : void
    {
        $registered = \false;
        $mb_registrar = $this->createMock(\pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Box_Registrar::class);
        $mb_registrar->method('register')->with()->will($this->returnCallback(function ($meta_box) use(&$registered) {
            $registered = \true;
        }));
        $md_registrar = $this->createMock(\pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Data_Registrar::class);
        $registrar = new \pc_stock_man_v1\PinkCrab\Registerables\Registrar\Shared_Meta_Box_Registrar($mb_registrar, $md_registrar);
        $registrar->register(new \pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\Shared_Metabox\Post_Page_Meta_Box());
        $this->assertTrue($registered);
    }
    /** @testdox When a meta boxes, meta data is registered, all none Meta_Data object should be removed using a filter. */
    public function test_filter_meta_data() : void
    {
        $data = array(new \pc_stock_man_v1\PinkCrab\Registerables\Meta_Data('one'), new \stdClass(), new \pc_stock_man_v1\PinkCrab\Registerables\Meta_Data('two'));
        $registrar = new \pc_stock_man_v1\PinkCrab\Registerables\Registrar\Shared_Meta_Box_Registrar($this->createMock(\pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Box_Registrar::class), $this->createMock(\pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Data_Registrar::class));
        $filtered = \pc_stock_man_v1\Gin0115\WPUnit_Helpers\Objects::invoke_method($registrar, 'filter_meta_data', array($data));
        $this->assertCount(2, $filtered);
        $this->assertContains($data[0], $filtered);
        $this->assertContains($data[2], $filtered);
    }
    /** @testdox When meta data is registered, if any errors are created, an exception should be thrown. */
    public function test_throws_exception_for_invalid_meta_data() : void
    {
        // Mock the meta data to throw and exception.
        $mock_meta_data = new \pc_stock_man_v1\PinkCrab\Registerables\Meta_Data('rr');
        $mock_meta_data->type('array')->rest_schema(\true);
        // Mock the controller to return the mock meta data.
        $mock_controller = $this->createMock(\pc_stock_man_v1\PinkCrab\Registerables\Tests\Fixtures\Shared_Metabox\Post_Page_Meta_Box::class);
        $mock_controller->method('meta_data')->willReturn(array($mock_meta_data));
        $mock_controller->method('meta_box')->willReturn(\pc_stock_man_v1\PinkCrab\Registerables\Meta_Box::side('test')->screen('post'));
        // Create the registrar with mock validator
        $mb_registrar = $this->createMock(\pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Box_Registrar::class);
        $md_registrar = $this->createMock(\pc_stock_man_v1\PinkCrab\Registerables\Registrar\Meta_Data_Registrar::class);
        $md_registrar->method('register_for_post_type')->willThrowException(new \Exception('Failed to register rr (meta) for post post type'));
        $registrar = new \pc_stock_man_v1\PinkCrab\Registerables\Registrar\Shared_Meta_Box_Registrar($mb_registrar, $md_registrar);
        // Prevent triggering error when calling doing it wrong.
        add_filter('doing_it_wrong_trigger_error', '__return_false');
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to register rr (meta) for post post type');
        $registrar->register($mock_controller);
        // Reset doing it wrong.
        add_filter('doing_it_wrong_trigger_error', '__return_true');
    }
}
