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

class App_Main_Translations implements JsonSerializable {

	use Json_Serialize_Translation_Trait;

	/**
	 * Apps title.
	 * @return string
	 */
	public function title(): string {
		return esc_html_x( 'Stock Man', 'The Apps title.', 'pc_stock_man' );
	}

	/**
	 * Apps subtitle.
	 * @return string
	 */
	public function subtitle(): string {
		return esc_html_x( 'Stock Management', 'The Apps subtitle.', 'pc_stock_man' );
	}

	


}