<?php

/**
 * Unit tests for the Options Repository.
 *
 * @package PinkCrab\Stock_Management\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */
namespace PinkCrab\Stock_Management\Tests\Unit\WP_Repository;

use PinkCrab\Stock_Management\WP_Repository\Options_Repository;

class Test_Options_Repository extends \WP_UnitTestCase {

    /** @testdox It should be possible to get a value from the options table using the repository */
   public function test_can_get_option()
    {
        $options = new Options_Repository();
        $value = $options->get('no_fallback');
        $this->assertFalse($value);

        $value = $options->get('with_fallback', 'fallback');
        $this->assertEquals('fallback', $value);

        // Set a mock option
        update_option('can_get_option', 'value');
        $value = $options->get('can_get_option');
        $this->assertEquals('value', $value);

        // CLean up and remove the mock option
        delete_option('can_get_option');
    }

    /** @testdox It should be possible to set a value in the options table using the repository and have the value autoloaded on wp init*/
    public function test_can_set_option_autoloaded()
    {
        $options = new Options_Repository();
        $value = $options->set_as_autoloaded('autoloaded', 'value');
        $this->assertTrue($value);

        $value = $options->get('autoloaded');
        $this->assertEquals('value', $value);

        // Should be set in autloaded data.
        $this->assertArrayHasKey('autoloaded', wp_load_alloptions());

        // Clean up and remove the mock option
        delete_option('autoloaded');
    }

    /** @testdox It should be possible to set a value in the options table using the repository and have the value NOT autoloaded on wp init*/
    public function test_can_set_option_not_autoloaded()
    {
        $options = new Options_Repository();
        $value = $options->set_as_not_autoloaded('not_autoloaded', 'value');
        $this->assertTrue($value);

        $value = $options->get('not_autoloaded');
        $this->assertEquals('value', $value);

        // Should NOT be set in autloaded data.
        $this->assertArrayNotHasKey('not_autoloaded', wp_load_alloptions());

        // Clean up and remove the mock option
        delete_option('not_autoloaded');
    }

    /** @testdox It should be possible to clear a value in the options table using the repository */
    public function test_can_clear_option()
    {
        $options = new Options_Repository();
        $value = $options->set_as_autoloaded('clear_option', 'value');
        $this->assertTrue($value);

        $value = $options->clear('clear_option');
        $this->assertTrue($value);

        $value = $options->get('clear_option');
        $this->assertFalse($value);

        // Clean up and remove the mock option
        delete_option('clear_option');
    }

    /** @testdox It should be possible to delete a value in the options table using the repository */
    public function test_can_delete_option()
    {
        $options = new Options_Repository();
        $value = $options->set_as_autoloaded('delete_option', 'value');
        $this->assertTrue($value);

        $value = $options->delete('delete_option');
        $this->assertTrue($value);

        $value = $options->get('delete_option');
        $this->assertFalse($value);

        // Clean up and remove the mock option
        delete_option('delete_option');
    }
}