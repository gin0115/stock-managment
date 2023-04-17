<?php

declare( strict_types=1 );

/**
 * Controller for the stock location page.
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

namespace PinkCrab\Stock_Management\WP_Admin\Page;

use PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue;
use PinkCrab\Stock_Management\User\User_Repository;
use PinkCrab\Stock_Management\WP_Admin\GUI\GUI_Router;
use PC_Woo_Stock_Man\PinkCrab\Perique_Admin_Menu\Page\Page;
use PinkCrab\Stock_Management\Location\Location_Repository;
use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;
use PC_Woo_Stock_Man\Gin0115\ViteManifestParser\ManifestParser;
use PC_Woo_Stock_Man\PinkCrab\Perique_Admin_Menu\Page\Menu_Page;

class Stock_Location_Page extends Menu_Page {

	private Plugin_Settings $settings;

	private ManifestParser $vue_manifest;

	private User_Repository $user_repository;

	private Location_Repository $location_repository;

	private GUI_Router $gui_router;

	private ServerRequestInterface $request;

	public function __construct(
		Plugin_Settings $settings,
		ManifestParser $vue_manifest,
		User_Repository $user_repository,
		Location_Repository $location_repository,
		GUI_Router $gui_router,
		ServerRequestInterface $request
	) {
		$this->settings            = $settings;
		$this->vue_manifest        = $vue_manifest;
		$this->user_repository     = $user_repository;
		$this->location_repository = $location_repository;
		$this->gui_router          = $gui_router;
		$this->request             = $request;

		$this->page_slug     = $settings->app_config()->admin_slugs->location;
		$this->menu_title    = $settings->translations()->stock_location()->location_page_title();
		$this->page_title    = $settings->translations()->stock_location()->location_page_title();
		$this->view_template = 'views/wp-admin/spa';
	}

	/**
	 * Handles all events prior to rendering the page.
	 *
	 * Used to trigger the setting of the view based on the GUI Router.
	 *
	 * @return void
	 */
	public function load( Page $page ): void {

		// Trigger any event we have registered.
		$event = $this->gui_router->get_on_load_event();
		if ( $event ) {
			$event();
		}
		$this->use_admin_gui();
	}

	/**
	 * Use Admin GUI
	 */
	public function use_admin_gui(): void {
		// Set the current route on first load.
		if ( ! isset( $_GET['gui_route'] ) ) {
			$_GET['gui_route'] = 'locations';
		}

		// Set the view based on the current Admin GUI route.

		$view = $this->gui_router->get_view();
		// If no view, bail
		if ( ! $view ) {
			return;
		}

		// Set the view template and data.
		$this->view_template = $view->get_view();
		$this->view_data     = $view->get_data();
		dump( $this );
	}

	/**
	 * Callback for enqueuing scripts and styles at a page level.
	 *
	 * @param Page $page
	 * @return void
	 */
	public function enqueue( Page $page ) : void {

		Enqueue::style( 'stockMan_bootstrap' )
			->src( 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css' )
			->register();
		Enqueue::style( 'stockMan_bootstrap_icons' )
			->src( 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css' )
			->register();
		Enqueue::script( 'stockMan_bootstrap' )
			->deps( 'jquery' )
			->src( 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js' )
			->register();

		Enqueue::script( 'stockMan_barcode' )
			->src( $this->settings->assets_url() . 'scripts/JsBarcode.all.min.js' )
			->deps( 'jquery' )
			->register();

		// If we are not rendering as a JS app.
		if ( ! $this->render_as_js_app() ) {
			return;
		}

		// Enqueue primary vue script.
		Enqueue::script( 'stockMan' )
			->script_type( 'module' )
			->src( $this->vue_manifest->getEntryScriptUri( 'index.html' ) )
			->localize(
				array(
					'i18n'     => $this->settings->translations(),
					'user'     => $this->user_repository->get_current_user(),
					'settings' => $this->settings->get_custom_settings(),
				)
			)
			->header()
			->register();

		// Iterate through all css files and enqueue them.
		foreach ( $this->vue_manifest->getEntryCssUris( 'index.html' ) as $key => $css_file ) {
			Enqueue::style( 'stockMan_' . $key )
				->src( $css_file )
				->register();
		}
	}

	/**
	 * Render as JS App
	 *
	 * @return bool
	 */
	private function render_as_js_app(): bool {
		// @todo hook up an option to render as js app.
		return false;
	}
}
