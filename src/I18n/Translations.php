<?php

declare( strict_types=1 );

/**
 * Primary index of all translations.
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
use PinkCrab\Stock_Management\I18n\App_Translations;
use PinkCrab\Stock_Management\I18n\Admin_GUI_Translations;
use PinkCrab\Stock_Management\I18n\Plugin_Settings_Translations;
use PinkCrab\Stock_Management\I18n\Json_Serialize_Translation_Trait;

class Translations implements JsonSerializable {

	use Json_Serialize_Translation_Trait;

	/**
	 * Get plugin settings translations.
	 *
	 * @return \PinkCrab\Stock_Management\I18n\Plugin_Settings_Translations
	 */
	public function plugin_settings(): Plugin_Settings_Translations {
		return new Plugin_Settings_Translations();
	}

	/**
	 * Get stock location translations.
	 *
	 * @return \PinkCrab\Stock_Management\I18n\Stock_Location_Translations
	 */
	public function stock_location(): Stock_Location_Translations {
		return new Stock_Location_Translations();
	}

	/**
	 * Returns the main app translations.
	 *
	 * @return App_Translations
	 */
	public function app(): App_Translations {
		return new App_Translations();
	}

	/**
	 * Returns the Admin GUI Translations.
	 *
	 * @return Admin_Gui_Translations
	 */
	public function admin_gui(): Admin_Gui_Translations {
		return new Admin_Gui_Translations();
	}

}
