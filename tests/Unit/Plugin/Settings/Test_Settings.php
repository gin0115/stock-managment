<?php

/**
 * Unit tests for the Plugin Settings Model
 *
 * @package PinkCrab\Stock_Management\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */
namespace PinkCrab\Stock_Management\Tests\Unit\Plugin\Settings;

use stdClass;
use PinkCrab\Stock_Management\Plugin\Settings\Settings;

class Test_Settings extends \WP_UnitTestCase {

	/** @testdox It should be possible to create an instance of the settings model, by passing all null values and have it populated by defaults. */
	public function test_is_populated_construct_from_defaults() {
		$plugin_settings = new Settings( null, null, null, null );
		$this->assertTrue( is_bool( $plugin_settings->use_location_bins() ) );
        $this->assertTrue( is_bool( $plugin_settings->use_location_sites() ) );
        $this->assertTrue( is_bool( $plugin_settings->use_pack_size_modifiers() ) );
        $this->assertTrue( is_bool( $plugin_settings->allow_partial_orders() ) );
	}

    /** @testdox It should be possible to create and instance of the settings model, by passing NO values and it being populated from defaults. */
    public function test_is_populated_construct_from_defaults_no_values() {
        $plugin_settings = new Settings();
        $this->assertTrue( is_bool( $plugin_settings->use_location_bins() ) );
        $this->assertTrue( is_bool( $plugin_settings->use_location_sites() ) );
        $this->assertTrue( is_bool( $plugin_settings->use_pack_size_modifiers() ) );
        $this->assertTrue( is_bool( $plugin_settings->allow_partial_orders() ) );
    } 

    /** @testdox It should be possible to create and instance of the settings model, by passing in values and it being populated from them. */   
    public function test_is_populated_construct_from_values() {
        $plugin_settings = new Settings( true, false, true, false );
        
        $this->assertTrue( $plugin_settings->use_location_sites() );
        $this->assertFalse( $plugin_settings->use_location_bins() );
        $this->assertTrue( $plugin_settings->use_pack_size_modifiers() );
        $this->assertFalse( $plugin_settings->allow_partial_orders() );
    }

    /** @testdox It should be possible to export the model as JSON using the JsonSerialize interface. */
    public function test_json_serialize() {
        $plugin_settings = new Settings( true, false, true, false );
        
        // Check class implements JSON serialize interface.
        $this->assertTrue( $plugin_settings instanceof \JsonSerializable );
        
        $json = json_encode( $plugin_settings );
        $this->assertEquals( '{"use_location_sites":true,"use_location_bins":false,"use_pack_size_modifiers":true,"allow_partial_orders":false}', $json );
    }


}
