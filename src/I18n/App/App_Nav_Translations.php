<?php

declare(strict_types=1);

/**
 * Main App (Wrapper) Translations
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace PinkCrab\Stock_Management\I18n\App;

use JsonSerializable;
use PinkCrab\Stock_Management\I18n\Json_Serialize_Translation_Trait;

class App_Nav_Translations implements JsonSerializable {

	use Json_Serialize_Translation_Trait;

	/**
	 * The home/dashboard link text on main app menu
	 * @return string
	 */
	public function home(): string {
		return esc_html_x( 'Dashboard', 'The home/dashboard link text on main app menu', 'pc_stock_man' );
	}

	/**
	 * The locations link text on main app menu
	 * @return string
	 */
	public function locations(): string {
		return esc_html_x( 'Locations', 'The locations link text on main app menu', 'pc_stock_man' );
	}

}