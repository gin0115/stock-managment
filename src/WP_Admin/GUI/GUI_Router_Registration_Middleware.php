<?php

declare( strict_types=1 );

/**
 * Registration middleware for the GUI Router.
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

use PinkCrab\Stock_Management\WP_Admin\GUI\GUI_Router;
use PinkCrab\Stock_Management\WP_Admin\GUI\Route\Route;
use PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\DI_Container;
use PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\Registration_Middleware;

class GUI_Router_Registration_Middleware implements Registration_Middleware {

	private ?DI_Container $container;
	private array $routes = array();
	private array $events = array();


	/**
	 * Constructor
	 *
	 * @param DI_Container $container
	 */
	public function __construct( DI_Container $container ) {
		$this->container = $container;
		$this->push_routes();
	}


	/** @inheritDoc */
	public function setup(): void {}

	/** @inheritDoc */
	public function process( $class ) {
		// If class implements the GUI_Router interface.
		if ( in_array( Route::class, class_implements( $class ) ?: array(), true ) ) {
			$class_name = get_class( $class );
			/** @var Route */
			$route = $this->container->create( $class_name );

			$this->routes[ $route->get_route_slug() ] = $route;
			$this->events[ $route->get_route_slug() ] = $route->on_load_events();
		}

	}

	/**
	 * Pushes the routes to the container.
	 *
	 * Does this by reference to get around the race condition.
	 *
	 * @return void
	 */
	private function push_routes(): void {
		$this->container->addRules(
			array(
				GUI_Router::class => array(
					'constructParams' => array( &$this->routes, &$this->events ),
					'shared'          => false,
				),
			)
		);
	}

	/** @inheritDoc */
	public function tear_down(): void {
		$this->push_routes();
	}

}
