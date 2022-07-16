<?php

declare(strict_types=1);

/**
 * Trait for adding JSON Serialize support to a translation class.
 * Takes each public method and sets method name as key and the value as the return value
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace PinkCrab\Stock_Management\I18n;

trait Json_Serialize_Translation_Trait {

	/**
	 * Get the array of translations.
	 *
	 * @return array
	 */
	public function jsonSerialize(): array {
		$translations = array();

		// Get all public methods except this one.
		$methods = get_class_methods( $this );
		foreach ( $methods as $method ) {
			if ( $method !== __FUNCTION__ ) {
				$translations[ $method ] = $this->$method();
			}
		}

		return $translations;
	}

}
