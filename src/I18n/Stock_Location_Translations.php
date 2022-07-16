<?php

declare( strict_types=1 );

/**
 * All translations relating to Stock Locations.
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

namespace PinkCrab\Stock_Management\I18n;

use JsonSerializable;
use PinkCrab\Stock_Management\I18n\Json_Serialize_Translation_Trait;

class Stock_Location_Translations implements JsonSerializable {

	use Json_Serialize_Translation_Trait;

	/**
	 * The single label for the Stock Location taxonomy
	 * @return string
	 */
	public function location_tax_single(): string {
		return esc_html_x( 'Location', 'The single label for the Stock Location taxonomy', 'pc_stock_man' );
	}

	/**
	 * The plural label for the Stock Location taxonomy
	 * @return string
	 */
	public function location_tax_plural(): string {
		return esc_html_x( 'Locations', 'The plural label for the Stock Location taxonomy', 'pc_stock_man' );
	}

	/**
	 * The description fro the  Stock Location taxonomy
	 * @return string
	 */
	public function location_tax_description(): string {
		return esc_html_x( 'Holds the stock locations.', 'The description fro the  Stock Location taxonomy', 'pc_stock_man' );
	}

	/**
	 * The page title used in menus for Stock Locations
	 * @return string
	 */
	public function location_page_title(): string {
		return esc_html_x( 'Holds the stock locations.', 'The page title used in menus for Stock Locations', 'pc_stock_man' );
	}

	/**
	 * The description of the location type meta field.
	 * @return string
	 */
	public function location_type_meta_description(): string {
		return esc_html_x( 'The type of location, can be Site, Bay or Bin', 'A locations type meta field description. Used in rest etc.', 'pc_stock_man' );
	}


}
