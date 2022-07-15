<?php

declare(strict_types=1);

/**
 * The Plugin Settings Model
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace PinkCrab\Stock_Management\Plugin\Settings;

class Settings implements \JsonSerializable {

	/** @var bool */
	private $use_location_sites = true;

	/** @var bool */
	private $use_location_bins = true;

	/** @var bool */
	private $use_pack_size_modifiers = false;

	/** @var bool */
	private $allow_partial_orders = false;

	public function __construct(
		?bool $use_location_sites = null,
		?bool $use_location_bins = null,
		?bool $use_pack_size_modifiers = null,
		?bool $allow_partial_orders = null
	) {
		if ( $use_location_sites !== null ) {
			$this->use_location_sites = $use_location_sites;
		}

		if ( $use_location_bins !== null ) {
			$this->use_location_bins = $use_location_bins;
		}

		if ( $use_pack_size_modifiers !== null ) {
			$this->use_pack_size_modifiers = $use_pack_size_modifiers;
		}

		if ( $allow_partial_orders !== null ) {
			$this->allow_partial_orders = $allow_partial_orders;
		}
	}

	/**
	 * Does the installation make use of location sites?
	 *
	 * @return bool
	 */
	public function use_location_sites(): bool {
		return $this->use_location_sites;
	}

	/**
	 * Does the installation make use of location bins?
	 *
	 * @return bool
	 */
	public function use_location_bins(): bool {
		return $this->use_location_bins;
	}

	/**
	 * Does the installation make use of pack size modifiers?
	 *
	 * @return bool
	 */
	public function use_pack_size_modifiers(): bool {
		return $this->use_pack_size_modifiers;
	}

	/**
	 * Does the installation allow partial orders?
	 *
	 * @return bool
	 */
	public function allow_partial_orders(): bool {
		return $this->allow_partial_orders;
	}

	/**
	 * Allow encoding for JSON.
	 *
	 * @return array
	 */
	public function jsonSerialize(): array {
		return array(
			'use_location_sites'      => $this->use_location_sites(),
			'use_location_bins'       => $this->use_location_bins(),
			'use_pack_size_modifiers' => $this->use_pack_size_modifiers(),
			'allow_partial_orders'    => $this->allow_partial_orders(),
		);
	}
}
