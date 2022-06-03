<?php

declare(strict_types=1);

/**
 * Handles the setting and getting of plugin information
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace PinkCrab\Stock_Management\Plugin;

use stdClass;
use PinkCrab\Stock_Management\WP_Repository\Options_Repository;
use PinkCrab\Stock_Management\Exception\Plugin_Settings_Exception;

class Plugin_Settings {

	protected const SETTINGS_KEY            = 'pc_woo_stock_man';
	protected const LOCATION_SITES_KEY      = 'location_sites';
	protected const LOCATION_BINS_KEY       = 'location_bins';
	protected const PACK_SIZE_MODIFIERS_KEY = 'location_modifiers';
	protected const PICK_PARTIAL_ORDER_KEY  = 'location_partial_orders';

	/**
	 * Access for settings and getting from the WP options table
	 *
	 * @var Options_Repository
	 */
	protected $options_repository;

	/**
	 * Defines if the site will use "Sites" as the top level of the
	 * location hierarchy
	 *
	 * @var bool
	 * @default true
	 */
	protected $use_location_sites;

	/**
	 * Defines if the site will use "Bins" as a lower level of the location
	 * hierarchy
	 *
	 * @var bool
	 * @default true
	 */
	protected $use_location_bins;

	/**
	 * Defines if the site should use pack size modifier
	 *
	 * @var bool
	 * @default false
	 */
	protected $use_pack_size_modifiers;

	/**
	 * Defines if the site will allow partially picked orders
	 * and if stock should be held for partially piked items
	 *
	 * @var bool
	 * @default true
	 */
	protected $use_pick_partial_orders;

	public function __construct( Options_Repository $options_repository ) {
		$this->options_repository = $options_repository;
		$this->set_vars();
	}

	/**
	 * Will set the inital state of the plugin settings if not already
	 * defined.
	 *
	 * @return void
	 */
	protected function set_vars(): void {
		$vars = $this->options_repository->get( self::SETTINGS_KEY, new \stdClass() );

		$get_value = function( string $key, $default ) use ( $vars ) {
			return is_object( $vars ) && property_exists( $vars, $key )
				? $vars->$key : $default;
		};

		$this->use_location_sites      = $get_value( self::LOCATION_SITES_KEY, true );
		$this->use_location_bins       = $get_value( self::LOCATION_BINS_KEY, true );
		$this->use_pack_size_modifiers = $get_value( self::PACK_SIZE_MODIFIERS_KEY, false );
		$this->use_pick_partial_orders = $get_value( self::PICK_PARTIAL_ORDER_KEY, true );
	}

	/**
	 * Saves the current state of the settings
	 *
	 * @return void
	 * @throws Plugin_Settings_Exception
	 */
	protected function save(): void {
		$vars                                  = new stdClass();
		$vars->{self::LOCATION_BINS_KEY}       = $this->use_location_bins;
		$vars->{self::LOCATION_SITES_KEY}      = $this->use_location_sites;
		$vars->{self::PACK_SIZE_MODIFIERS_KEY} = $this->use_pack_size_modifiers;
		$vars->{self::PICK_PARTIAL_ORDER_KEY}  = $this->use_pick_partial_orders;

		// if update fails, throw Plugin Settings exception
		if ( ! $this->options_repository->set_as_autoloaded( self::SETTINGS_KEY, $vars ) ) {
			throw Plugin_Settings_Exception::failed_to_update_settings_option();
		}
	}

	/**
	 * Sets the value of the use_location_sites property
	 *
	 * @param bool $use_location_sites
	 * @return self
	 */
	public function set_use_location_sites( bool $use_location_sites ): self {
		$this->use_location_sites = $use_location_sites;
		$this->save();
		return $this;
	}

	/**
	 * Sets the value of the use_location_bins property
	 *
	 * @param bool $use_location_bins
	 * @return self
	 */
	public function set_use_location_bins( bool $use_location_bins ): self {
		$this->use_location_bins = $use_location_bins;
		$this->save();
		return $this;
	}

	/**
	 * Sets the value of the use_pack_size_modifiers property
	 *
	 * @param bool $use_pack_size_modifiers
	 * @return self
	 */
	public function set_use_pack_size_modifiers( bool $use_pack_size_modifiers ): self {
		$this->use_pack_size_modifiers = $use_pack_size_modifiers;
		$this->save();
		return $this;
	}

	/**
	 * Sets the value of the use_pick_partial_orders property
	 *
	 * @param bool $use_pick_partial_orders
	 * @return self
	 */
	public function set_use_pick_partial_orders( bool $use_pick_partial_orders ): self {
		$this->use_pick_partial_orders = $use_pick_partial_orders;
		$this->save();
		return $this;
	}

	/**
	 * Gets the value of the use_location_sites property
	 *
	 * @return bool
	 */
	public function get_use_location_sites(): bool {
		return $this->use_location_sites;
	}

	/**
	 * Gets the value of the use_location_bins property
	 *
	 * @return bool
	 */
	public function get_use_location_bins(): bool {
		return $this->use_location_bins;
	}

	/**
	 * Gets the value of the use_pack_size_modifiers property
	 *
	 * @return bool
	 */
	public function get_use_pack_size_modifiers(): bool {
		return $this->use_pack_size_modifiers;
	}

	/**
	 * Gets the value of the use_pick_partial_orders property
	 *
	 * @return bool
	 */
	public function get_use_pick_partial_orders(): bool {
		return $this->use_pick_partial_orders;
	}
}
