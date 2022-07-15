<?php

declare( strict_types=1 );

/**
 * Registers the location taxonomy.
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

namespace PinkCrab\Stock_Management\Location;

use PC_Woo_Stock_Man\PinkCrab\Registerables\Taxonomy;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Meta_Data;
use PC_Woo_Stock_Man\PinkCrab\Perique\Application\App_Config;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;
use PinkCrab\Stock_Management\I18n\Stock_Location_Translations;

class Location_Taxonomy extends Taxonomy {

	// Location names, used for term definitions.
	public const LOCATION_SITE = 'site';
	public const LOCATION_BAY  = 'bay';
	public const LOCATION_BIN  = 'bin';

	public $hierarchical       = true;
	public $object_type        = array( 'product' );
	public $show_in_quick_edit = false;
	public $show_in_rest       = true;

	private $plugin_settings;

	private $location_translations;

	/** @param Plugin_Settings $plugin_settings */
	public function __construct( Plugin_Settings $plugin_settings ) {
		$this->plugin_settings       = $plugin_settings;
		$this->location_translations = $plugin_settings->translations()->stock_location();

		$this->slug        = $this->plugin_settings->location_taxonomy();
		$this->singular    = $this->location_translations->location_tax_single();
		$this->plural      = $this->location_translations->location_tax_plural();
		$this->description = $this->location_translations->location_tax_description();

	}

	/**
	 * Allows for the setting of meta data specifically for this taxonomy.
	 *
	 * @param Meta_Data[] $collection
	 * @return Meta_Data[]
	 */
	public function meta_data( array $collection ) : array {
		$collection[] = ( new Meta_Data( $this->plugin_settings->app_config()->term_meta( 'type' ) ) )
			->type( 'string' )
			->description( $this->location_translations->location_type_meta_description() )
			->single( true )
			->sanitize( 'sanitize_text_field' )
			->default( self::LOCATION_BAY );

		return $collection;
	}
}
