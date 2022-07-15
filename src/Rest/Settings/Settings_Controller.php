<?php

declare( strict_types=1 );

/**
 * The REST controller for plugin settings.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Stock_Management
 */

namespace PinkCrab\Stock_Management\Rest\Settings;

use WP_REST_Request;
use WP_REST_Response;
use PinkCrab\Stock_Management\Rest\Rest_Auth;
use PC_Woo_Stock_Man\PinkCrab\Route\Route\Route;
use PC_Woo_Stock_Man\PinkCrab\Route\Route_Factory;
use PC_Woo_Stock_Man\PinkCrab\Route\Route\Route_Group;
use PinkCrab\Stock_Management\Plugin\Settings\Settings;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;
use PC_Woo_Stock_Man\PinkCrab\Route\Registration_Middleware\Route_Controller;

class Settings_Controller extends Route_Controller {

	/** @var Plugin_Settings */
	private $plugin_settings;

	/** @var Rest_Auth */
	private $auth;

	public function __construct(
		Plugin_Settings $plugin_settings,
		Rest_Auth $auth
	) {
		$this->plugin_settings = $plugin_settings;
		$this->auth            = $auth;
		$this->namespace       = $plugin_settings->rest_namespace();
	}

	/**
	 * Defines all the routes for Plugin Settings
	 *
	 * @param Route_Factory $factory
	 * @return array<Route|Route_Group>
	 */
	public function define_routes( Route_Factory $route_factory ): array {
		// Define the group.
		return array(
			$route_factory->group_builder(
				'/settings',
				function( Route_Group $group ) {
					// All methods require the user to logged in and an administrator.
					$group->authentication(
						$this->auth->multiple_all(
							$this->auth->is_logged_in(),
							$this->auth->is_role( 'administrator' )
						)
					);

					// Get all settings.
					$group->get( array( $this, 'get' ) );

					// Update all settings.
					$group->post( array( $this, 'update' ) );

					// Delete all settings.
					$group->delete( array( $this, 'delete' ) );

					return $group;
				}
			),
		);

	}

	/**
	 * Returns the current state of the plugin settings.
	 *
	 * @return \WP_REST_Response
	 */
	public function get( \WP_REST_Request $request ): \WP_REST_Response { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
		return new \WP_REST_Response(
			array( 'settings' => $this->plugin_settings->get_custom_settings() ),
			200
		);
	}

	/**
	 * Updates the plugin settings.
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response
	 */
	public function update( \WP_REST_Request $request ): \WP_REST_Response {
		$body = $request->get_body_params();

		// Pull the values from the body.
		$pluck = function( string $key ) use ( $body ) {
			return \array_key_exists( $key, $body )
				? filter_var( $body[ $key ], FILTER_VALIDATE_BOOLEAN )
				: null;
		};

		// Get the existing settings.
		$existing = $this->plugin_settings->get_custom_settings();

		// Create new settings.
		$settings = new Settings(
			$pluck( 'use_location_sites' ) ?? $existing->use_location_sites(),
			$pluck( 'use_location_bins' ) ?? $existing->use_location_bins(),
			$pluck( 'use_pack_size_modifiers' ) ?? $existing->use_pack_size_modifiers(),
			$pluck( 'pick_partial_orders' ) ?? $existing->allow_partial_orders()
		);

		// Update the settings.
		$this->plugin_settings->set_custom_settings( $settings );

		// Return success message.
		return new \WP_REST_Response(
			array(
				'message'  => $this->plugin_settings
								->translations()
								->plugin_settings()
								->update_success_notification(),
				'settings' => $this->plugin_settings->get_custom_settings(),
			),
			200
		);

	}

	/**
	 * Deletes the current settings
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response
	 */
	public function delete( WP_REST_Request $request ): WP_REST_Response { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
		$this->plugin_settings->delete_custom_settings();
		return new WP_REST_Response(
			array(
				'message' => $this->plugin_settings
								->translations()
								->plugin_settings()
								->delete_success_notification(),
			),
			200
		);
	}


}
