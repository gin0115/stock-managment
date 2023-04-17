<?php

declare(strict_types=1);

/**
 * Admin GUI Translations.
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace PinkCrab\Stock_Management\I18n;

use JsonSerializable;
use PinkCrab\Stock_Management\I18n\Json_Serialize_Translation_Trait;
use PinkCrab\Stock_Management\I18n\Admin_GUI\GUI_Location_Translations;

class Admin_GUI_Translations implements JsonSerializable {

	use Json_Serialize_Translation_Trait;

	/**
	 * All Admin GUI Translations for Location routes.
	 *
	 * @return GUI_Location_Translations
	 */
	public function locations(): GUI_Location_Translations {
		return new GUI_Location_Translations();
	}

}
