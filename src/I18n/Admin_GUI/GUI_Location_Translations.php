<?php

declare(strict_types=1);

/**
 * All Location GUI route translations.
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace PinkCrab\Stock_Management\I18n\Admin_GUI;

use JsonSerializable;
use PhpParser\Node\Expr\Cast\String_;
use PinkCrab\Stock_Management\I18n\App\App_Nav_Translations;
use PinkCrab\Stock_Management\I18n\App\App_Main_Translations;
use PinkCrab\Stock_Management\I18n\Json_Serialize_Translation_Trait;

class GUI_Location_Translations implements JsonSerializable {

	use Json_Serialize_Translation_Trait;

	/**
	 * Location Admin GUI route nav title.
	 * @return string
	 */
	public function nav_title(): string {
		return esc_html_x( 'Locations', 'Location Admin GUI route nav title.', 'pc_stock_man' );
	}

	/**
	 * Location type [Site] label for Location GUI route nav
	 * @return string
	 */
	public function nav_site_label(): string {
		return esc_html_x( 'Sites', 'Location type [Site] label for Location GUI route nav', 'pc_stock_man' );
	}

	/**
	 * Location type [Aisle] label for Location GUI route nav
	 * @return string
	 */
	public function nav_aisle_label(): string {
		return esc_html_x( 'Aisles', 'Location type [Aisle] label for Location GUI route nav', 'pc_stock_man' );
	}

	/**
	 * Location type [Bin] label for Location GUI route nav
	 * @return string
	 */
	public function nav_bin_label(): string {
		return esc_html_x( 'Bins', 'Location type [Bin] label for Location GUI route nav', 'pc_stock_man' );
	}


}
