<?php

declare(strict_types=1);

/**
 * Plugin Settings Exception
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace PinkCrab\Stock_Management\Exception;

use PinkCrab\Stock_Management\I18n\Plugin_Settings_Translations;

class Plugin_Settings_Exception extends \Exception {

	/**
	 * Returns an instance of the Plugin_Settings_Exception class.
	 *
	 * @return \PinkCrab\Stock_Management\I18n\Plugin_Settings_Translations
	 */
	protected static function get_translations(): Plugin_Settings_Translations {
		return new Plugin_Settings_Translations();
	}

	/**
	 * Returns predefined exception for failing to update settings.
	 *
	 * @return Plugin_Settings_Exception
	 * @code 201
	 */
	public static function failed_to_update_settings_option(): self {
		return new self( self::get_translations()->failed_to_update_settings() );
	}
}

