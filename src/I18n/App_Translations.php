<?php

declare(strict_types=1);

/**
 * App Translations.
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace PinkCrab\Stock_Management\I18n;

use JsonSerializable;
use PinkCrab\Stock_Management\I18n\App\App_Nav_Translations;
use PinkCrab\Stock_Management\I18n\App\App_Main_Translations;
use PinkCrab\Stock_Management\I18n\Json_Serialize_Translation_Trait;

class App_Translations implements JsonSerializable {

	use Json_Serialize_Translation_Trait;

	/**
	 * All Main App Translations (Header, footer, etc).
	 *
	 * @return App_Main_Translations
	 */
	public function main(): App_Main_Translations {
		return new App_Main_Translations();
	}

	/**
	 * All Nav App Translations (Navigation, etc).
	 *
	 * @return App_Nav_Translations
	 */
	public function nav(): App_Nav_Translations {
		return new App_Nav_Translations();
	}
}
