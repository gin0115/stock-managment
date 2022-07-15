<?php

/**
 * Unit tests for the Stock Location Translation service
 *
 * @package PinkCrab\Stock_Management\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */
namespace PinkCrab\Stock_Management\Tests\Unit\Plugin;

use PinkCrab\Stock_Management\Tests\Helper\Hook_Trait;
use PinkCrab\Stock_Management\I18n\Stock_Location_Translations;

class Test_Stock_Location_Translations extends \WP_UnitTestCase {
	use Hook_Trait;

	private $translations;

	public function setUp(): void {
		parent::setUp();
		$this->translations = new Stock_Location_Translations();
	}

	/** @testdox The location_tax_single message should be run through WP's translate service under the projects text domain */
	public function test_location_tax_single() {
		$this->assert_esc_html_x_called( 'pc_stock_man' )(
			function() {
				$this->translations->location_tax_single();
			}
		);
	}

	/** @testdox The location_tax_plural message should be run through WP's translate service under the projects text domain */
	public function test_location_tax_plural() {
		$this->assert_esc_html_x_called( 'pc_stock_man' )(
			function() {
				$this->translations->location_tax_plural();
			}
		);
	}

	/** @testdox The location_tax_description message should be run through WP's translate service under the projects text domain */
	public function test_location_tax_description() {
		$this->assert_esc_html_x_called( 'pc_stock_man' )(
			function() {
				$this->translations->location_tax_description();
			}
		);
	}

	/** @testdox The location_page_title message should be run through WP's translate service under the projects text domain */
	public function test_location_page_title() {
		$this->assert_esc_html_x_called( 'pc_stock_man' )(
			function() {
				$this->translations->location_page_title();
			}
		);
	}

	/** @testdox The location_type_meta_description message should be run through WP's translate service under the projects text domain */
	public function test_location_type_meta_description() {
		$this->assert_esc_html_x_called( 'pc_stock_man' )(
			function() {
				$this->translations->location_type_meta_description();
			}
		);
	}

}
