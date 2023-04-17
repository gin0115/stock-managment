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
use PinkCrab\Stock_Management\Location\Model\Location;
use PinkCrab\Stock_Management\WP_Admin\GUI\Link_Maker;
use PinkCrab\Stock_Management\WP_Admin\GUI\View_Model;
use PC_Woo_Stock_Man\PinkCrab\Perique\Application\Config;
use PinkCrab\Stock_Management\Location\Location_Taxonomy;
use PinkCrab\Stock_Management\Location\Location_Repository;
use PC_Woo_Stock_Man\PinkCrab\Perique\Application\App_Config;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap\Link;
use PinkCrab\Stock_Management\I18n\Admin_GUI\GUI_Location_Translations;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Shared\Simple_Nav;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Location\Site_Card;

class Locations_Route implements Route {

	private string $page_slug;
	private Location_Repository $location_repository;
	private Plugin_Settings $settings;
	private GUI_Location_Translations $translations;

	public function __construct( Plugin_Settings $settings, Location_Repository $location_repository ) {
		$this->page_slug           = $settings->app_config()->admin_slugs->location;
		$this->location_repository = $location_repository;
		$this->settings            = $settings;
		$this->translations        = $settings->translations()->admin_gui()->locations();
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
		return 'locations';
	}

	/**
	 * Returns the shared nav component.
	 *
	 * @return Simple_Nav
	 */
	protected function get_nav(): Simple_Nav {
		$slug = $this->get_page_slug();

		return new Simple_Nav(
			new Link( $this->translations->nav_title(), array( 'href' => Link_Maker::for( $slug ) ) ),
			array(
				Link::nav_item(
					$this->translations->nav_site_label(),
					array(
						'class' => 'text-white',
						'href'  => Link_Maker::for( $slug )->route( 'sites' ),
					)
				),
				Link::nav_item( $this->translations->nav_aisle_label(), array( 'href' => Link_Maker::for( $slug )->route( 'aisles' ) ) ),
				Link::nav_item( $this->translations->nav_bin_label(), array( 'href' => Link_Maker::for( $slug )->route( 'bins' ) ) ),
			)
		);
	}

	/**
	 * Returns the index (list) view path.
	 *
	 * @return View_Model
	 */
	public function index_view(): ?View_Model {
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

		// dump($this->get_nav());

		return new View_Model(
			'views.wp-admin.pages.location.site.index',
			array(
				'sites' => $sites,
				'nav'   => $this->get_nav(),
			)
		);
	}

	/**
	 * Returns the create view path.
	 *
	 * @return string
	 */
	public function create_view(): ?View_Model {
		return new View_Model( 'views.wp-admin.pages.error', array( 'message' => 'This page is not yet implemented' ) );
	}

	/**
	 * Returns the edit view path.
	 *
	 * @return string
	 */
	public function edit_view(): ?View_Model {
		return new View_Model( 'views.wp-admin.pages.error', array( 'message' => 'This page is not yet implemented' ) );
	}

	/**
	 * Returns the delete view path.
	 *
	 * @return string
	 */
	public function delete_view(): ?View_Model {
		return new View_Model( 'views.wp-admin.pages.error', array( 'message' => 'This page is not yet implemented' ) );
	}

	/**
	 * Return all on load events.
	 * These are run before the routing is initiated.
	 *
	 * @return array<string, callable>
	 */
	public function on_load_events(): array {
		return array();
	}
}
