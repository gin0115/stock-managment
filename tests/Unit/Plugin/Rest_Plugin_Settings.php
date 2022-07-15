<?php

/**
 * Unit tests for the Plugin Settings service
 *
 * @package PinkCrab\Stock_Management\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */
namespace PinkCrab\Stock_Management\Tests\Unit\Plugin;

use stdClass;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;
use PinkCrab\Stock_Management\WP_Repository\Options_Repository;
use PinkCrab\Stock_Management\I18n\Plugin_Settings_Translations;
use PinkCrab\Stock_Management\Exception\Plugin_Settings_Exception;

class Test_Plugin_Settings extends \WP_UnitTestCase {

	/** @testdox It should be possible to create an instance of the settings and have the values populated from persistent storage */
	public function test_is_populated_construct_from_options() {
		$settings                      = new stdClass();
		$settings->location_sites      = false;
		$settings->location_bins       = false;
		$settings->pack_size_modifiers = true;
		$settings->partial_orders      = true;

		$options_repository = $this->createMock( Options_Repository::class );
		$options_repository->method( 'get' )->willReturn( $settings );

		$plugin_settings = new Plugin_Settings( $options_repository );

		$this->assertEquals( $settings->location_sites, $plugin_settings->get_use_location_sites() );
		$this->assertEquals( $settings->location_bins, $plugin_settings->get_use_location_bins() );
		$this->assertEquals( $settings->pack_size_modifiers, $plugin_settings->get_use_pack_size_modifiers() );
		$this->assertEquals( $settings->partial_orders, $plugin_settings->get_use_pick_partial_orders() );
	}

	/** @testdox It should be possible to create an instance of the settings and have the values populated using defaults if not in persistent storage*/
	public function test_is_populated_construct_from_defaults() {

		$options_repository = $this->createMock( Options_Repository::class );
		$options_repository->method( 'get' )->willReturn( false );

		$plugin_settings = new Plugin_Settings( $options_repository );

		$this->assertEquals( true, $plugin_settings->get_use_location_sites() );
		$this->assertEquals( true, $plugin_settings->get_use_location_bins() );
		$this->assertEquals( false, $plugin_settings->get_use_pack_size_modifiers() );
		$this->assertEquals( false, $plugin_settings->get_use_pick_partial_orders() );
	}

	/** @testdox It should be possible to update a setting and have it save the settings data to persistent storage */
	public function test_save_runs_after_setting_property(): void {
		$options_repository = $this->createMock( Options_Repository::class );

		// Count the number of times the save method is called.
		$count = 0;
		$options_repository
			->method( 'set_as_autoloaded' )
			->willReturnCallback(
				function ( $value ) use ( &$count ): bool {
					$count++;
					return true;
				}
			);

		$plugin_settings = new Plugin_Settings( $options_repository );
		$plugin_settings->set_use_location_bins( true );
		$plugin_settings->set_use_location_sites( false );
		$plugin_settings->set_use_pack_size_modifiers( true );
		$plugin_settings->set_use_pick_partial_orders( false );

		$this->assertEquals( 4, $count );
	}

	/** @testdox If a setting can not be saved to persistent storage then a Plugin Settings Exception should be thrown */
	public function test_save_throws_exception_if_setting_cant_be_saved(): void {

		$options_repository = $this->createMock( Options_Repository::class );
		$options_repository
			->method( 'set_as_autoloaded' )
			->willReturn( false );

		$plugin_settings = new Plugin_Settings( $options_repository );

		$this->expectException( Plugin_Settings_Exception::class );
		$this->expectExceptionMessage( ( new Plugin_Settings_Translations() )->failed_to_update_settings() );
		$plugin_settings->set_use_location_bins( true );
	}

	/** @testdox It should be possible to set and get the use bin locations property */
	public function test_get_set_use_location_bins() {
		$options_repository = $this->createMock( Options_Repository::class );
		$options_repository->method( 'get' )->willReturn( false );
		$options_repository->method( 'set_as_autoloaded' )->willReturn( true );

		$plugin_settings = new Plugin_Settings( $options_repository );

		$this->assertEquals( true, $plugin_settings->get_use_location_bins() );
		$plugin_settings->set_use_location_bins( false );
		$this->assertEquals( false, $plugin_settings->get_use_location_bins() );
	}

    /** @testdox It should be possible to set and get the use pack size modifiers property */
    public function test_get_set_use_pack_size_modifiers() {
        $options_repository = $this->createMock( Options_Repository::class );
        $options_repository->method( 'get' )->willReturn( false );
        $options_repository->method( 'set_as_autoloaded' )->willReturn( true );

        $plugin_settings = new Plugin_Settings( $options_repository );

        $this->assertEquals( false, $plugin_settings->get_use_pack_size_modifiers() );
        $plugin_settings->set_use_pack_size_modifiers( true );
        $this->assertEquals( true, $plugin_settings->get_use_pack_size_modifiers() );
    }

    /** @testdox It should be possible to set and get the use pick partial orders property */
    public function test_get_set_use_pick_partial_orders() {
        $options_repository = $this->createMock( Options_Repository::class );
        $options_repository->method( 'get' )->willReturn( false );
        $options_repository->method( 'set_as_autoloaded' )->willReturn( true );

        $plugin_settings = new Plugin_Settings( $options_repository );

        $this->assertEquals( false, $plugin_settings->get_use_pick_partial_orders() );
        $plugin_settings->set_use_pick_partial_orders( true );
        $this->assertEquals( true, $plugin_settings->get_use_pick_partial_orders() );
    }

    /** @testdox It should be possible to set and get the use location sites property */
    public function test_get_set_use_location_sites() {
        $options_repository = $this->createMock( Options_Repository::class );
        $options_repository->method( 'get' )->willReturn( false );
        $options_repository->method( 'set_as_autoloaded' )->willReturn( true );

        $plugin_settings = new Plugin_Settings( $options_repository );

        $this->assertEquals( true, $plugin_settings->get_use_location_sites() );
        $plugin_settings->set_use_location_sites( false );
        $this->assertEquals( false, $plugin_settings->get_use_location_sites() );
    }



}
