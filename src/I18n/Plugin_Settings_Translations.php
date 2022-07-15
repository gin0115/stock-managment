<?php

declare(strict_types=1);

/**
 * Plugin Translation strings.
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace PinkCrab\Stock_Management\I18n;

class Plugin_Settings_Translations {


	/**
	 * Settings update notification for successfully updating.
	 * @return string
	 */
	public function update_success_notification(): string {
		return esc_html_x( 'Custom settings updated', 'The success notification updating custom settings.', 'pc_stock_man' );
	}

	/**
	 * Settings update notification for failed to update
	 * @return string
	 */
	public function update_failed_notification(): string {
		return esc_html_x( 'Failed to update custom settings.', 'The failed notification updating custom settings.', 'pc_stock_man' );
	}

	/**
	 * Message for successfully deleting the options.
	 * @return string
	 */
	public function delete_success_notification(): string {
		return esc_html_x( 'Custom settings deleted', 'The success notification deleting custom settings.', 'pc_stock_man' );
	}


	/**
	 * Message for failing to delete the options.
	 * @return string
	 */
	public function delete_failed_notification(): string {
		return esc_html_x( 'Failed to delete custom settings', 'The failed notification deleting custom settings.', 'pc_stock_man' );
	}


}
