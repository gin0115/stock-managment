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

namespace PinkCrab\Stock_Management\Rest\Location;

use WP_REST_Request;
use WP_REST_Response;
use PinkCrab\Stock_Management\Rest\Rest_Auth;
use PC_Woo_Stock_Man\PinkCrab\Route\Route\Route;
use PC_Woo_Stock_Man\PinkCrab\Route\Route_Factory;
use PC_Woo_Stock_Man\PinkCrab\Route\Route\Route_Group;
use PinkCrab\Stock_Management\Plugin\Settings\Settings;
use PinkCrab\Stock_Management\Location\Location_Repository;
use PinkCrab\Stock_Management\Location\Model\Location_Site;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;
use PC_Woo_Stock_Man\PinkCrab\Route\Registration_Middleware\Route_Controller;

class Location_Controller extends Route_Controller {

	private Location_Repository $location_repository;

	private Plugin_Settings $plugin_settings;

	private Rest_Auth $auth;

	public function __construct(
		Location_Repository $location_repository,
		Plugin_Settings $plugin_settings,
		Rest_Auth $auth
	) {
		$this->location_repository = $location_repository;
		$this->plugin_settings     = $plugin_settings;
		$this->auth                = $auth;
		$this->namespace           = $plugin_settings->rest_namespace();
	}

	/**
	 * Defines all the routes for Plugin Settings
	 *
	 * @param Route_Factory $factory
	 * @return array<Route|Route_Group>
	 */
	public function define_routes( Route_Factory $route_factory ): array {
		return array(
			$route_factory->group_builder(
				'/locations',
				function( Route_Group $group ) {
					// All methods require the user to logged in and an administrator.
					$group->authentication( $this->auth->is_logged_in_admin() );

					// Get all settings.
					$group->get( array( $this, 'get' ) );

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
		$sites = $this->location_repository->get_all_sites();

		$locations = array_reduce(
			$sites,
			function( array $locations, Location_Site $site ) {
				$locations[] = array(
					'site'     => $site,
					'children' => $this->location_repository->get_aisles_for_site( $site ),
				);
				return $locations;
			},
			array()
		);

		return new \WP_REST_Response( array( 'locations' => $locations ), 200 );
	}

	/**
	 * Updates the plugin settings.
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response
	 */
	public function update( \WP_REST_Request $request ): \WP_REST_Response {
		return new \WP_REST_Response( array( 'a' => 'todo' ), 200 );

	}

	/**
	 * Deletes the current settings
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response
	 */
	public function delete( WP_REST_Request $request ): WP_REST_Response { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
		return new \WP_REST_Response( array( 'a' => 'todo' ), 200 );
	}


}
