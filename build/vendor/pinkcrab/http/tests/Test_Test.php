<?php

namespace PC_Woo_Stock_Man;

/**
 * Sample Test
 *
 * @package PinkCrab/Tests
 */
use PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP;
class Test_Test extends \WP_UnitTestCase
{
    function test_wordpress_and_plugin_are_loaded()
    {
        $this->assertTrue(\function_exists('PC_Woo_Stock_Man\\do_action'));
    }
    function test_wp_phpunit_is_loaded_via_composer()
    {
        $this->assertStringStartsWith(\dirname(__DIR__) . '/vendor/', \getenv('WP_PHPUNIT__DIR'));
        $this->assertStringStartsWith(\dirname(__DIR__) . '/vendor/', (new \ReflectionClass('WP_UnitTestCase'))->getFileName());
    }
}
\class_alias('PC_Woo_Stock_Man\\Test_Test', 'Test_Test', \false);
