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
use PC_Woo_Stock_Man\PinkCrab\Perique_Admin_Menu\Page\Page;
use PC_Woo_Stock_Man\PinkCrab\Perique\Application\App_Config;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;
use PinkCrab\Stock_Management\I18n\Stock_Location_Translations;
use PC_Woo_Stock_Man\PinkCrab\Perique_Admin_Menu\Page\Menu_Page;

class Stock_Location_Page extends Menu_Page {

	/* @var App_Config */
	private $config;

	/* @var Stock_Location_Translations*/
	private $translations;

	/** @var Plugin_Settings */
	private $settings;

	/** @var Spa_Assets */
	private $assets;


	public function __construct(
		App_Config $config,
		Stock_Location_Translations $translations,
		Plugin_Settings $settings,
		Spa_Assets $assets
	) {
		$this->config       = $config;
		$this->translations = $translations;
		$this->settings     = $settings;
		$this->assets       = $assets;

		$this->page_slug     = $this->config->admin_slugs->location;
		$this->menu_title    = $this->translations->location_page_title();
		$this->page_title    = $this->translations->location_page_title();
		$this->view_template = 'wp-admin.page.stock-location';
		$this->view_data     = array(
			'i18n'     => $this->translations,
			'settings' => $this->settings,
		);
	}

	/**
	 * Callback for enqueuing scripts and styles at a page level.
	 *
	 * @param Page $page
	 * @return void
	 */
	public function enqueue( Page $page ) : void {
		Enqueue::script( 'stock_man' )
			->src( $this->assets->get_js_uri() )
			->localize(
				array(
					'foo' => 'bar',
				)
			)
            ->attribute('type', 'module')
            ->header()
			->register();
	}
}
