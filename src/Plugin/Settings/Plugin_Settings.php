<?php

declare(strict_types=1);

/**
 * Handles the setting and getting of plugin information
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace PinkCrab\Stock_Management\Plugin\Settings;

use PinkCrab\Stock_Management\I18n\Translations;
use PinkCrab\Stock_Management\Plugin\Settings\Settings;
use PC_Woo_Stock_Man\PinkCrab\Perique\Application\App_Config;
use PinkCrab\Stock_Management\WP_Repository\Options_Repository;

class Plugin_Settings {

	protected const SETTINGS_KEY = 'pc_woo_stock_man';

	/** @var Options_Repository */
	private $options_repository;

	/** @var App_Config */
	private $app_config;

	/** @var Translations */
	private $translations;

	public function __construct(
		Options_Repository $options_repository,
		App_Config $app_config,
		Translations $translations
	) {
		$this->options_repository = $options_repository;
		$this->app_config         = $app_config;
		$this->translations       = $translations;
	}

	/**
	 * Gets the current settings from persistent storage
	 *
	 * @return Settings
	 */
	public function get_custom_settings(): Settings {
		return $this->options_repository->get( self::SETTINGS_KEY, new Settings() );
	}

	/**
	 * sets a passed settings instance to persistent storage
	 *
	 * @param Settings $settings
	 * @return bool
	 */
	public function set_custom_settings( Settings $settings ): bool {
		return $this->options_repository->set_as_not_autoloaded( self::SETTINGS_KEY, $settings );
	}

	/**
	 * Deletes the custom settings.
	 * 
	 * @return bool
	 */
	public function delete_custom_settings(): bool {
		return $this->options_repository->clear( self::SETTINGS_KEY );
	}

	/**
	 * Access to all translations
	 *
	 * @return \PinkCrab\Stock_Management\I18n\Translations
	 */
	public function translations(): Translations {
		return $this->translations;
	}

	/**
	 * Access the App Config
	 * @return App_Config
	 */
	public function app_config(): App_Config {
		return $this->app_config;
	}

	/**
	 * Get the plugin rest namespace
	 *
	 * @return string
	 */
	public function rest_namespace(): string {
		return $this->app_config->rest();
	}

	/**
	 * Get the plugin version
	 *
	 * @return string
	 */
	public function version(): string {
		return $this->app_config->version();
	}

	/**
	 * Get the Location Taxonomy Key
	 *
	 * @return string
	 */
	public function location_taxonomy(): string {
		return $this->app_config->taxonomies( 'location' );
	}

	/**
	 * Get the Location Menu Page slug
	 *
	 * @return string
	 */
	public function location_menu_page(): string {
		return $this->app_config->additional( 'admin_slugs' )->location;
	}



}
