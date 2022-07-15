<?php

/**
 * Trait with helper method and test assertions for working with hooks.
 *
 * @package PinkCrab\Stock_Management\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */
namespace PinkCrab\Stock_Management\Tests\Helper;

use Closure;

trait Hook_Trait {

		/**
		* Assert that the given hook is fired.
		*
		* @param string $hook_name
		* @param string $message
		* @return void
		*/
	public function assert_hook_fired( string $hook_name, string $message = '' ): void {
		$this->assertTrue( did_action( $hook_name ), $message );
	}


	/**
	 * Assert string is exists as part of a defined domain.
	 * @param string $string
	 * @param string $domain
	 * @param string $message
	 * @return Closure
	 */
	public function assert_translation_with_context_exists_for_domain( string $expected_domain, string $message = '' ): Closure {

		return function( Closure $event ) use ( $expected_domain, $message ) {

			$called = false;
			add_filter(
				'gettext_with_context_' . $expected_domain,
				function( $translated, $text, $context, $domain ) use ( &$called ) {
						$called = true;
					return $translated;
				},
				10,
				4
			);

			// call the event that triggers the translation.
			$event();

			// Check that the translation was called for this text domain
			$this->assertTrue( $called, $message );
		};
	}

	public function assert_esc_html_x_called( string $expected_domain, string $message = '' ): Closure {

		return function( Closure $event ) use ( $expected_domain, $message ) {
			$translated_called = false;
			$escaped           = false;

			add_filter(
				'gettext_with_context_' . $expected_domain,
				function( $translated, $text, $context, $domain ) use ( &$translated_called ) {
					$translated_called = true;
					return $translated;
				},
				10,
				4
			);


			add_filter(
				'esc_html',
				function( $safe_text, $text ) use ( &$escaped ) {
					$escaped = true;
					return $safe_text;
				},
				10,
				2
			);

			// call the event that triggers the translation.
			$event();

			// Clear hooks.
			unset( $GLOBALS['wp_filter'][ 'gettext_with_context_' . $expected_domain ] );

			// Check that both were called.
			$this->assertTrue( $translated_called, "[translated] : {$message}" );
			$this->assertTrue( $escaped, "[escaped] : {$message}" );
		};
	}

}
