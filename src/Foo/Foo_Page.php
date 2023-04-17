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

namespace PinkCrab\Stock_Management\Foo;

use PinkCrab\Perique_Page_Router\Page\Router_Page;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;
use PC_Woo_Stock_Man\PinkCrab\Perique_Admin_Menu\Page\Menu_Page;

class Foo_Page extends Router_Page {

	private Plugin_Settings $settings;



	public function __construct(
		Plugin_Settings $settings
	) {
		$this->settings      = $settings;
		$this->page_slug     = $settings->app_config()->admin_slugs->location;
		$this->menu_title    = $settings->translations()->stock_location()->location_page_title();
		$this->page_title    = $settings->translations()->stock_location()->location_page_title();
		$this->view_template = 'views.wp-admin.spa';
			// dump(\is_a($this, \PC_Woo_Stock_Man\PinkCrab\Perique_Admin_Menu\Page\Page::class) );

		// dump($this  );
	}


	/** @inheritDoc */
	public function get_routes(): array {
		return array(
			Foo_List_Route::class,
		);
	}



}
