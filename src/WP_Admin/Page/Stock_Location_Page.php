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

use pc_stock_man_v1\PinkCrab\Perique_Admin_Menu\Page\Page;
use pc_stock_man_v1\PinkCrab\Perique\Application\App_Config;
use pc_stock_man_v1\PinkCrab\Perique_Admin_Menu\Page\Menu_Page;
use PinkCrab\Stock_Management\I18n\Stock_Location_Translations;

class Stock_Location_Page extends Menu_Page {

	/* @var App_Config */
	private $config;

	/* @var Stock_Location_Translations*/
	private $translations;

	public function __construct( App_Config $config, Stock_Location_Translations $translations ) {
		$this->config       = $config;
		$this->translations = $translations;

		$this->page_slug     = $this->config->admin_slugs->location;
		$this->menu_title    = $this->translations->location_page_title();
		$this->page_title    = $this->translations->location_page_title();
		$this->view_template = 'wp-admin.page.stock-location';
		$this->view_data     = array( 'i18n' => $this->translations );
	}

	/**
	 * Callback for enqueuing scripts and styles at a page level.
	 *
	 * @param Page $page
	 * @return void
	 */
	public function enqueue( Page $page ) : void {
		dump( $page );
	}
}
