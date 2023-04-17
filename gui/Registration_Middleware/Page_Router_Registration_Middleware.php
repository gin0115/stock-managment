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
 * @package PinkCrab\Perique_Page_Router
 */

namespace PinkCrab\Perique_Page_Router\Registration_Middleware;

use Symfony\Component\Console\Helper\Dumper;
use PinkCrab\Perique_Page_Router\Route\Route;
use PinkCrab\Perique_Page_Router\Router\Router;
use PinkCrab\Perique_Page_Router\Page\Router_Page;
use PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\DI_Container;
use PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\Registration_Middleware;

class Page_Router_Registration_Middleware implements Registration_Middleware {

	private ?DI_Container $container;
	private array $routes = array();
	private array $events = array();
	private $page;


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
		if ( $class instanceof Router_Page ) {
			$page_name = get_class( $class );

			// If page has not been set.
			if ( ! $this->page ) {
				/** @var Router_Page */
				$page = $this->container->create( $page_name );

				// If we dont get a page back, then we have a problem.
				if ( ! $page ) {
					throw new \Exception( 'Unable to create page: ' . $page_name );
				}

				// Set the page.
				$this->page = $page;
			}

			// If we are on the current page, consturct the page router.
			if ( ! array_key_exists( 'page', $_GET ) || $_GET['page'] !== $page->slug() ) {
				return;
			}

			// Get routes.
			$routes = $page->get_routes();
			foreach ( $routes as $route ) {

				$route = $this->container->create( $route );

				if ( false === $route instanceof Route ) {
					continue;
				}

				$this->routes[ $route->type() ] = $route;
				$this->events[ $route->type() ] = $route->preload_actions();
			}
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
				Router::class => array(
					'constructParams' => array( &$this->routes, &$this->events ),
					'shared'          => true,
				),

			)
		);

		// If page is set, add the page to the container.
		if ( $this->page ) {
			$this->container->addRules(
				array(
					get_class( $this->page ) => array(
						'shared' => true,
						'call'   => array( array( 'set_gui_router' ) ),
						'shared' => true,
					),
				)
			);
		}

	}

	/** @inheritDoc */
	public function tear_down(): void {
		$this->push_routes();
	}

}
