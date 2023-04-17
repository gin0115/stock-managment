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
 * @package PinkCrab\Perique_Page_Router
 */

namespace PinkCrab\Perique_Page_Router\Router;

use Symfony\Component\Console\Helper\Dumper;
use PinkCrab\Perique_Page_Router\Route\Route;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\View_Model;

class Router {

	public const INDEX  = 'index';
	public const CREATE = 'create';
	public const EDIT   = 'edit';
	public const DELETE = 'delete';
	public const SINGLE = 'single';

	protected array $routes = array();
	protected array $events = array();

	public function __construct( array $routes = array(), $events = array() ) {
		$this->routes = $routes;
		$this->events = $events;
	}

	/**
	 * Gets all the defined routes (keys)
	 *
	 * @return array<string>
	 */
	public function get_routes(): array {
		return array_keys( $this->routes );
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
			return self::INDEX;
		}

		return sanitize_text_field( wp_unslash( trim( $_GET['gui_route'] ) ) );
	}

	/**
	 * Get on load event for current route/action
	 *
	 * @return callable[]
	 */
	public function get_on_load_events(): array{
		$route = $this->get_current_route();
		if ( ! $route || ! array_key_exists( $route, $this->events ) ) {
			return null;
		}
		return $this->events[ $route ];
	}

	/**
	 * Gets the current view
	 *
	 * @return ?View_Model
	 */
	public function get_view(): ?View_Model {
		$route_name = $this->get_current_route();
		if ( ! $route_name ) {
			return null;
		}

		// If the route is not in the routes, return null.
		if ( ! \array_key_exists( $route_name, $this->routes ) ) {
			return null;
		}

		$route = $this->routes[ $route_name ];
		// If route is not a route controller, return null.
		if ( ! $route instanceof Route ) {
			return null;
		}

		return $route->view_model();
	}

}
