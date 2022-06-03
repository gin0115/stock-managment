<?php

/**
 * Unit tests for the Plugin Settings service
 *
 * @package PinkCrab\Stock_Management\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */
namespace PinkCrab\WP_Repository\Tests\Unit\Plugin;

use stdClass;
use PinkCrab\Stock_Management\Plugin\Plugin_Settings;

class Test_Plugin_Settings extends \WP_UnitTestCase {

	public function test_is_populated_construct_from_options() {
		$settings                          = new stdClass();
		$settings->use_location_sites      = true;
		$settings->use_location_bins       = true;
		$settings->use_pack_size_modifiers = true;
		$settings->use_partial_orders      = true;

		$options_repository = $this->createMock( Options_Repository::class );
		$options_repository->method( 'get' )->willReturn( $settings );

		$plugin_settings = new Plugin_Settings( $options_repository );

		$this->assertEquals( $settings->use_location_sites, $plugin_settings->use_location_sites );
		$this->assertEquals( $settings->use_location_bins, $plugin_settings->use_location_bins );
		$this->assertEquals( $settings->use_pack_size_modifiers, $plugin_settings->use_pack_size_modifiers );
		$this->assertEquals( $settings->use_partial_orders, $plugin_settings->use_partial_orders );

	}
}
