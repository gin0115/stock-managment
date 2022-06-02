<?php

declare (strict_types=1);
/**
 * Enqueue tests
 *
 * @since 1.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Core
 */
namespace PC_Woo_Stock_Man\PinkCrab\Core\Tests\Application;

use PC_Woo_Stock_Man\WP_UnitTestCase;
use PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue;
use PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects;
class Test_Enqueue extends \WP_UnitTestCase
{
    public function setUp()
    {
    }
    /**
     * Retruns a fully populated enqueue script isntance..
     *
     * @return \PinkCrab\Enqueue\Enqueue
     */
    protected static function create_script() : \PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue
    {
        return \PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue::script('script_handle')->src('https://url.com/Fixtures/script_file.js')->deps('jquery', 'angularjs')->ver('1.2.3')->footer(\false)->localize(array('key_int' => 1, 'key_array' => array('string', 'val')));
    }
    /**
     * Retruns a fully populated enqueue style isntance..
     * Uses latest file date.
     *
     * @return \PinkCrab\Enqueue\Enqueue
     */
    protected static function create_style() : \PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue
    {
        return \PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue::style('style_handle')->src('style_file.css')->deps('theme_styles', 'ache_plugin_styles')->ver('2.3')->media('(orientation: portrait)');
    }
    /**
     * Test can be concstrcuted
     *
     * @return void
     */
    public function test_can_create_from_constructor() : void
    {
        $enqueue = new \PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue('hook', 'script');
        $this->assertEquals('hook', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($enqueue, 'handle'));
        $this->assertEquals('script', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($enqueue, 'type'));
    }
    /**
     * Test script and stype statics create with type
     *
     * @return void
     */
    public function test_static_constructors() : void
    {
        $script = self::create_script();
        $this->assertEquals('script_handle', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'handle'));
        $this->assertEquals('script', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'type'));
        $style = self::create_style();
        $this->assertEquals('style_handle', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'handle'));
        $this->assertEquals('style', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'type'));
    }
    /**
     * Tests all script setters.
     *
     * @return void
     */
    public function test_script_setters() : void
    {
        $script = self::create_script();
        $this->assertEquals('script', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'type'));
        $this->assertEquals('script_handle', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'handle'));
        $this->assertEquals('https://url.com/Fixtures/script_file.js', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'src'));
        $this->assertEquals('1.2.3', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'ver'));
        $this->assertFalse(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'footer'));
        $this->assertIsArray(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'deps'));
        $this->assertEquals('jquery', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'deps')[0]);
        $this->assertEquals('angularjs', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'deps')[1]);
        $this->assertIsArray(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'localize'));
        $this->assertArrayHasKey('key_int', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'localize'));
        $this->assertIsInt(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'localize')['key_int']);
        $this->assertIsArray(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'localize')['key_array']);
    }
    /**
     * Tests all script setters.
     *
     * @return void
     */
    public function test_style_setters() : void
    {
        $style = self::create_style();
        $this->assertEquals('style', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'type'));
        $this->assertEquals('style_handle', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'handle'));
        $this->assertEquals('style_file.css', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'src'));
        $this->assertEquals('2.3', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'ver'));
        $this->assertEquals('(orientation: portrait)', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'media'));
        $this->assertIsArray(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'deps'));
        $this->assertEquals('theme_styles', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'deps')[0]);
        $this->assertEquals('ache_plugin_styles', \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'deps')[1]);
    }
    /** @testdox It should be possible to denote a scriptas async easily. */
    public function test_can_set_async_on_script() : void
    {
        $script = self::create_script()->async();
        $attributes = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'attributes');
        $this->assertArrayHasKey('async', $attributes);
    }
    /** @testdox It should be possible to denote a style as async easily. */
    public function test_can_set_async_style() : void
    {
        $style = self::create_style()->async();
        $attributes = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'attributes');
        $this->assertArrayHasKey('async', $attributes);
    }
    /** @testdox It should be possible to denote a scriptas defer easily. */
    public function test_can_set_defer_on_script() : void
    {
        $script = self::create_script()->defer();
        $attributes = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'attributes');
        $this->assertArrayHasKey('defer', $attributes);
    }
    /** @testdox It should be possible to denote a style as defer easily. */
    public function test_can_set_defer_style() : void
    {
        $style = self::create_style()->defer();
        $attributes = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'attributes');
        $this->assertArrayHasKey('defer', $attributes);
    }
    /** @testdox It should not be possible to set both async and defer, either should unset the other */
    public function test_can_only_be_async_or_defer() : void
    {
        $script = self::create_script()->async();
        $attributes = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'attributes');
        $this->assertArrayHasKey('async', $attributes);
        $this->assertArrayNotHasKey('defer', $attributes);
        $script->defer();
        $attributes = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'attributes');
        $this->assertArrayHasKey('defer', $attributes);
        $this->assertArrayNotHasKey('async', $attributes);
        $script->async();
        $attributes = \PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'attributes');
        $this->assertArrayHasKey('async', $attributes);
        $this->assertArrayNotHasKey('defer', $attributes);
    }
    /** @testdox It should be possible to define if a script is added to the header */
    public function test_can_set_script_in_header() : void
    {
        $script = \PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue::script('header')->header();
        $this->assertFalse(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'footer'));
    }
    /** @testdox It should be possible to toggle if a script in enqueued inline. */
    public function test_can_set_script_as_inline() : void
    {
        $script = \PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue::script('header')->inline();
        $this->assertTrue(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'inline'));
        // As false
        $script = \PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue::script('header')->inline(\false);
        $this->assertFalse(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'inline'));
        // Verbose true.
        $script = \PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue::script('header')->inline(\true);
        $this->assertTrue(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'inline'));
    }
    /** @testdox It should be possible to toggle if a script in enqueued is for a block or not.. */
    public function test_can_set_script_for_block() : void
    {
        // False by default.
        $script = \PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue::script('for_block');
        $this->assertFalse(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'for_block'));
        // Set as true with no value passed.
        $script = \PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue::script('for_block')->for_block();
        $this->assertTrue(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($script, 'for_block'));
        // As false
        $style = \PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue::style('for_block')->for_block(\false);
        $this->assertFalse(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'for_block'));
        // Verbose true.
        $style = \PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue::style('for_block')->for_block(\true);
        $this->assertTrue(\PC_Woo_Stock_Man\Gin0115\WPUnit_Helpers\Objects::get_property($style, 'for_block'));
    }
}
