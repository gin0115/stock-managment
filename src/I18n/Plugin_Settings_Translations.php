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
	 * Failed to update settings option.
	 *
	 * @return string
	 */
	public function failed_to_update_settings(): string {
		return __( 'Failed to update settings.', 'pc-woo-stock-man' );
	}

}
