<?php

/**
 * Unit tests for the Plugin Settings service
 *
 * @package PinkCrab\Stock_Management\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */
namespace PinkCrab\Stock_Management\Tests\Unit\Plugin;

use PinkCrab\Stock_Management\Tests\Helper\Hook_Trait;
use PinkCrab\Stock_Management\I18n\Plugin_Settings_Translations;

class Test_Plugin_Settings_Translations extends \WP_UnitTestCase {
	use Hook_Trait;

	private $translations;

	public function setUp(): void {
		parent::setUp();
		$this->translations = new Plugin_Settings_Translations();
	}

	/** @testdox The update_success_notification message should be run through WP's translate service under the projects text domain */
	public function test_update_success_notification_message() {
		$this->assert_esc_html_x_called( 'pc_stock_man' )(
			function() {
				$this->translations->update_success_notification();
			}
		);
	}

	/** @testdox The update_failed_notification message should be run through WP's translate service under the projects text domain */
	public function test_update_failed_notification_message() {
		$this->assert_esc_html_x_called( 'pc_stock_man' )(
			function() {
				$this->translations->update_failed_notification();
			}
		);
	}

	/** @testdox The delete_success_notification message should be run through WP's translate service under the projects text domain */
	public function test_delete_success_notification_message() {
		$this->assert_esc_html_x_called( 'pc_stock_man' )(
			function() {
				$this->translations->delete_success_notification();
			}
		);
	}

	/** @testdox The delete_failed_notification message should be run through WP's translate service under the projects text domain */
	public function test_delete_failed_notification_message() {
		$this->assert_esc_html_x_called( 'pc_stock_man' )(
			function() {
				$this->translations->delete_failed_notification();
			}
		);
	}



}
