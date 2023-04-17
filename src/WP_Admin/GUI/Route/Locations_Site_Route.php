<?php

declare( strict_types=1 );

/**
 * Locations route for the admin GUI.
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

namespace PinkCrab\Stock_Management\WP_Admin\GUI\Route;

use getID3;
use PC_Woo_Stock_Man\PinkCrab\Nonce\Nonce;
use PinkCrab\Stock_Management\WP_Admin\GUI\Form\Form;
use PinkCrab\Stock_Management\Location\Model\Location;
use PinkCrab\Stock_Management\WP_Admin\GUI\GUI_Router;
use PinkCrab\Stock_Management\WP_Admin\GUI\Link_Maker;
use PinkCrab\Stock_Management\WP_Admin\GUI\View_Model;
use PinkCrab\Stock_Management\Location\Location_Repository;
use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;
use PinkCrab\Stock_Management\WP_Admin\GUI\Action\Site_Form_Handler;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap\Link;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Shared\Simple_Nav;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Location\Site_Card;

class Locations_Site_Route implements Route {

	public const ROUTE_SLUG = 'sites';

	private string $page_slug;
	private Location_Repository $location_repository;
	private Plugin_Settings $settings;
	private Site_Form_Handler $form_handler;
	private Nonce $nonce;
	private ServerRequestInterface $request;


	public function __construct(
		Plugin_Settings $settings,
		Location_Repository $location_repository,
		Site_Form_Handler $form_handler,
		ServerRequestInterface $request
	) {
		$this->page_slug           = $settings->app_config()->admin_slugs->location;
		$this->location_repository = $location_repository;
		$this->settings            = $settings;
		$this->form_handler        = $form_handler;
		$this->nonce               = new Nonce( Site_Form_Handler::FORM_NONCE );
		$this->request             = $request;

	}

	/**
	 * Returns the WP page slug for the route.
	 *
	 * @return string
	 */
	public function get_page_slug(): string {
		return $this->settings->app_config()->admin_slugs->location;
	}

	/**
	 * Returns the base slug for the route.
	 *
	 * @return string
	 */
	public function get_route_slug(): string {
		return 'sites';
	}

	/**
	 * Returns the shared nav component.
	 *
	 * @return Simple_Nav
	 */
	protected function get_nav(): Simple_Nav {
		$slug = $this->get_page_slug();

		return new Simple_Nav(
			new Link( 'Locations', array( 'href' => Link_Maker::for( $slug ) ) ),
			array(
				Link::nav_item(
					'Sites',
					array(
						'href'  => Link_Maker::for( $slug )->route( 'sites' ),
						'class' => 'current',
					)
				),
				Link::nav_item( 'aisles', array( 'href' => Link_Maker::for( $slug )->route( 'aisles' ) ) ),
				Link::nav_item( 'bins', array( 'href' => Link_Maker::for( $slug )->route( 'bins' ) ) ),
			)
		);
	}

	/**
	 * Returns the index (list) view path.
	 *
	 * @return View_Model
	 */
	public function index_view(): ?View_Model {

		// Check if we are displaying a single site.
		if ( array_key_exists( 'location_id', $this->request->getQueryParams() ) ) {
			return new View_Model(
				'views.wp-admin.pages.location.site.single',
				array(
					'site' => $this->location_repository->find( absint( $this->request->getQueryParams()['location_id'] ) ),
					'nav'  => $this->get_nav(),
				)
			);
		}

		// Get all sites, with count of aisles and products.
		$sites = array_reduce(
			$this->location_repository->get_all_sites(),
			function( array $carry, Location $site ): array {
				$carry[] = new Site_Card(
					$site,
					$this->location_repository->get_aisles_for_site( $site ),
					123
				);
				return $carry;
			},
			array()
		);

		return new View_Model(
			'views.wp-admin.pages.location.site.index',
			array(
				'sites'           => $sites,
				'nav'             => $this->get_nav(),
				'new_site_button' => Link::button( 'New Site', array( 'href' => Link_Maker::for( $this->get_page_slug() )->route( 'sites' )->action( 'create' ) ) ),
			)
		);
	}

	/**
	 * Returns the create view path.
	 *
	 * @return string
	 */
	public function create_view(): ?View_Model {
		return new View_Model(
			'views.wp-admin.pages.location.site.edit',
			array(
				'message'   => "{$this->get_page_slug()}:{$this->get_route_slug()}(INDEX) This page is not yet implemented",
				'nav'       => $this->get_nav(),
				'site_name' => get_option( 'siteName' ),
				'nonce'     => $this->nonce->token(),
				'form'      => new Form(
					$this->form_handler->get_notifications(),
					$this->request,
					'create',
					null !== $this->request->getParsedBody()
				),
			)
		);
		return null;
	}

	/**
	 * Returns the edit view path.
	 *
	 * @return string
	 */
	public function edit_view(): ?View_Model {

		// Get site ID from URL.
		$site_id = filter_input( INPUT_GET, 'site_id', FILTER_SANITIZE_NUMBER_INT );

		// If we dont have a site URL, return error view.

		return new View_Model(
			'views.wp-admin.pages.locations',
			array(
				'sites'     => array(),
				'nav'       => $this->get_nav(),
				'site_name' => '',
			)
		);
	}

	/**
	 * Returns the delete view path.
	 *
	 * @return string
	 */
	public function delete_view(): ?View_Model {
		return new View_Model(
			'views.wp-admin.pages.error',
			array(
				'message' => "{$this->get_page_slug()}:{$this->get_route_slug()}(DELETE) This page is not yet implemented",
			)
		);
	}

	/**
	 * Return all on load events.
	 * These are run before the routing is initiated.
	 *
	 * @return array<string, callable>
	 */
	public function on_load_events(): array {
		return array(
			GUI_Router::CREATE => array( $this->form_handler, 'create' ),
		);
	}
}
