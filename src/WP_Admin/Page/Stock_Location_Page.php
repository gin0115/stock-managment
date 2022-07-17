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

use PinkCrab\Stock_Management\SPA\Spa_Assets;
use PC_Woo_Stock_Man\PinkCrab\Enqueue\Enqueue;
use PinkCrab\Stock_Management\User\User_Repository;
use PC_Woo_Stock_Man\PinkCrab\Perique_Admin_Menu\Page\Page;
use PC_Woo_Stock_Man\PinkCrab\Perique\Application\App_Config;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;
use PinkCrab\Stock_Management\I18n\Stock_Location_Translations;
use PC_Woo_Stock_Man\PinkCrab\Perique_Admin_Menu\Page\Menu_Page;

class Stock_Location_Page extends Menu_Page {

	/** @var App_Config */
	private $config;

	/** @var Stock_Location_Translations */
	private $translations;

	/** @var Plugin_Settings */
	private $settings;

	/** @var Spa_Assets */
	private $assets;

	/** @var User_Repository */
	private $user_repository;


	public function __construct(
		Plugin_Settings $settings,
		Spa_Assets $assets,
		User_Repository $user_Repository
	) {
		$this->settings        = $settings;
		$this->assets          = $assets;
		$this->user_repository = $user_Repository;

		$this->page_slug     = $settings->app_config()->admin_slugs->location;
		$this->menu_title    = $settings->translations()->stock_location()->location_page_title();
		$this->page_title    = $settings->translations()->stock_location()->location_page_title();
		$this->view_template = 'views/wp-admin/spa';
	}

	/**
	 * Callback for enqueuing scripts and styles at a page level.
	 *
	 * @param Page $page
	 * @return void
	 */
	public function enqueue( Page $page ) : void {
		// Enqueue primary vue script.
		Enqueue::script( 'stockMan' )
			->src( $this->assets->get_js_uri() )
			->localize(
				array(
					'i18n'     => $this->settings->translations(),
					'user'     => $this->user_repository->get_current_user(),
					'settings' => $this->settings->get_custom_settings(),
				)
			)
			->script_type( 'module' )
			->header()
			->register();

		// Iterate through all css files and enqueue them.
		foreach ( $this->assets->get_css_uris() as $key => $css_file ) {
			Enqueue::style( 'stockMan_' . $key )
				->src( $css_file )
				->register();
		}
	}
}
