<?php

/**
 * Unit tests for the Translation service
 *
 * @package PinkCrab\Stock_Management\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */
namespace PinkCrab\Stock_Management\Tests\Unit\Plugin;

use PinkCrab\Stock_Management\I18n\Translations;
use PinkCrab\Stock_Management\I18n\Stock_Location_Translations;
use PinkCrab\Stock_Management\I18n\Plugin_Settings_Translations;

class Test_Translations extends \WP_UnitTestCase {

	/** @testdox It should be possible ot access the Stock Location translations */
	public function test_stock_location(): void {
		$translations = new Translations();
		$this->assertInstanceOf( Stock_Location_Translations::class, $translations->stock_location() );
	}

	/** @testdox It should be possible to access the Plugin Settings translations */
	public function test_plugin_settings(): void {
		$translations = new Translations();
		$this->assertInstanceOf( Plugin_Settings_Translations::class, $translations->plugin_settings() );
	}

}
