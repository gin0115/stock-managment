<?php

declare( strict_types=1 );

/**
 * Handles the routing of the admin GUI.
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

namespace PinkCrab\Stock_Management\WP_Admin\GUI;

use PinkCrab\Stock_Management\WP_Admin\GUI\View_Model;

class GUI_Router {

	public const INDEX  = 'index';
	public const CREATE = 'create';
	public const EDIT   = 'edit';
	public const DELETE = 'delete';

	protected array $routes = array();
	protected array $events = array();

	public function __construct( array $routes = array(), $events = array() ) {
		$this->routes = $routes;
		$this->events = $events;
	}

	/**
	 * Checks if the current page is a route and is valid.
	 *
	 * @return bool
	 */
	public function is_route( $slug ): bool {
		// Check if the current page is the main page.
		if ( ! isset( $_GET['page'] ) || $_GET['page'] !== $slug ) {
			return false;
		}

		// Check if current route is valid.
		$route = $this->get_current_route();
		if ( ! $route ) {
			return false;
		}

		// Check if the current view is valid.
		return \array_key_exists( $route, $this->routes );
	}

	/**
	 * Returns the current route.
	 *
	 * @return string
	 */
	public function get_current_route(): ?string {
		// If no route is set, return null
		if ( ! isset( $_GET['gui_route'] ) ) {
			return null;
		}

		return sanitize_text_field( wp_unslash( trim( $_GET['gui_route'] ) ) );
	}

	/**
	 * Returns the current action.
	 *
	 * @return string
	 */
	public function get_current_action(): string {
		// If no route is set, return index
		if ( ! isset( $_GET['gui_action'] ) ) {
			return self::INDEX;
		}

		return sanitize_text_field( wp_unslash( trim( $_GET['gui_action'] ) ) );
	}

	/**
	 * Get on load event for current route/action
	 *
	 * @return ?callable
	 */
	public function get_on_load_event(): ?callable {
		$route = $this->get_current_route();

		if ( ! $route || ! array_key_exists( $route, $this->routes ) ) {
			return null;
		}

		$route_controller = $this->routes[ $route ];

		// If action is within methods, return the view.
		$events = $route_controller->on_load_events();
		if ( ! \array_key_exists( $this->get_current_action(), $events ) ) {
			return null;
		}

		return $events[ $this->get_current_action() ];
	}

	/**
	 * Gets the current view
	 *
	 * @return ?View_Model
	 */
	public function get_view(): ?View_Model {
		$route = $this->get_current_route();
		if ( ! $route ) {
			return null;
		}

		// If the route is not in the routes, return null.
		if ( ! \array_key_exists( $route, $this->routes ) ) {
			return null;
		}

		$methods = array(
			self::INDEX  => 'index_view',
			self::CREATE => 'create_view',
			self::EDIT   => 'edit_view',
			self::DELETE => 'delete_view',
		);

		// If action is within methods, return the view.
		if ( \array_key_exists( $this->get_current_action(), $methods ) ) {
			return $this->routes[ $route ]->{$methods[ $this->get_current_action() ]}();
		}

		return '';
	}

}
