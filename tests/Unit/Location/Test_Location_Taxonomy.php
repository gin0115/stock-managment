<?php

/**
 * Unit tests for the location taxonomy registerable.
 *
 * @package PinkCrab\Stock_Management\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */
namespace PinkCrab\Stock_Management\Tests\Unit\Location;

use stdClass;
use PinkCrab\Stock_Management\I18n\Translations;
use PinkCrab\Stock_Management\Location\Location_Taxonomy;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;
use PinkCrab\Stock_Management\I18n\Stock_Location_Translations;

class Test_Location_Taxonomy extends \WP_UnitTestCase {

	/** @testdox When the location taxonomy is registered all the defined labels should be translated, using a translation service. */
	public function test_register_taxonomy_labels() {
		// Mock the Location Translation service.
		$location_translations = $this->createMock( Stock_Location_Translations::class );
        $location_translations->method( 'location_tax_single' )->willReturn( 'location_tax_single' );
        $location_translations->method( 'location_tax_plural' )->willReturn( 'location_tax_plural' );
        $location_translations->method( 'location_tax_description' )->willReturn( 'location_tax_description' );

		// Mock the Translation service.
		$translations = $this->createMock( Translations::class );
		$translations->method( 'stock_location' )->willReturn( $location_translations );

        // Mock plugin settings.
        $plugin_settings = $this->createMock( Plugin_Settings::class );
        $plugin_settings->method( 'translations' )->willReturn( $translations );

        $tax = new Location_Taxonomy( $plugin_settings );

        // Check all labels taken from the translation service.
        $this->assertEquals( 'location_tax_single', $tax->singular );
        $this->assertEquals( 'location_tax_plural', $tax->plural );
        $this->assertEquals( 'location_tax_description', $tax->description );
	}

    /** @testdox When the location taxonomy is registered the slug should be taken from plugin settings service. */
    public function test_register_taxonomy_slug() {
        // Mock plugin settings.
        $plugin_settings = $this->createMock( Plugin_Settings::class );
        $plugin_settings->method( 'location_taxonomy' )->willReturn( 'location-taxonomy-slug' );

        $tax = new Location_Taxonomy( $plugin_settings );

        // Check the slug taken from the plugin settings service.
        $this->assertEquals( 'location-taxonomy-slug', $tax->slug );
    }
}
