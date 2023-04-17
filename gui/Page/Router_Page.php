<?php

declare( strict_types=1 );

/**
 * Abstract class for all router pages.
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

namespace PinkCrab\Perique_Page_Router\Page;

use PinkCrab\Perique_Page_Router\Route\Route;
use PC_Woo_Stock_Man\PinkCrab\Perique_Admin_Menu\Page\Page;

use PinkCrab\Perique_Page_Router\Router\Router;
use PC_Woo_Stock_Man\PinkCrab\Perique_Admin_Menu\Page\Menu_Page;

abstract class Router_Page extends Menu_Page {

	/**
	 * The GUI Router.
	 *
	 * @var Router
	 */
	protected $gui_router;

	/**
	 * Sets the router post __construct.
	 *
	 * @param Router $gui_router
	 */
	final public function set_gui_router( Router $gui_router ): void {
		$this->gui_router = $gui_router;
	}

	/**
	 * @inheritDoc
	 */
	public function load( Page $page ): void {
		dump( 2, $this );

		// Trigger any event we have registered.
		$events = $this->gui_router->get_on_load_events();
		if ( ! empty( $events ) ) {
			foreach ( $events as $event ) {
                dump($event);
				$event();
			}
		}
		$this->set_router_view();
	}

	/**
	 * Use Admin GUI
	 */
	protected function set_router_view(): void {
		// Set the current route on first load.
		if ( ! isset( $_GET['gui_route'] ) ) {
			$_GET['gui_route'] = $this->default_route();
		}

		// Set the view based on the current Admin GUI route.
		$view = $this->gui_router->get_view();

		// If no view, bail
		if ( ! $view ) {
			return;
		}

		// Set the view template and data.
		$this->view_template = $view->template();
		$this->view_data     = $view->data();
	}

	/**
	 * Gets the default route.
	 *
	 * @return string|null
	 */
	private function default_route(): ?string {
		$routes = $this->gui_router->get_routes();

		// If no routes defined, bail.
		if ( empty( $routes ) ) {
			return null;
		}

		// If INDEX route is defined, use it.
		if ( array_key_exists( Route::INDEX, $routes ) ) {
			return Route::INDEX;
		}

		// If no INDEX route, use the first route.
		return reset( $routes );
	}

	/**
	 * Abstract class to get all routes.
	 *
	 * @return array<int, class-name<Route>>
	 */
	abstract public function get_routes(): array;
}
