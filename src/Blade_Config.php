<?php

declare( strict_types=1 );

/**
 * The custom Blade One config
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

namespace PinkCrab\Stock_Management;

use PC_Woo_Stock_Man\PinkCrab\Perique\Application\App;
use PC_Woo_Stock_Man\PinkCrab\BladeOne\BladeOne_Provider;
use PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\DI_Container;
use PC_Woo_Stock_Man\PinkCrab\BladeOne\Abstract_BladeOne_Config;
use PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\Inject_DI_Container;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap\Button;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\Container_Aware_Traits\Inject_DI_Container_Aware;

class Blade_Config extends Abstract_BladeOne_Config implements Inject_DI_Container {

	use Inject_DI_Container_Aware;

	private App $app;

	public function __construct( App $app ) {
		$this->app = $app;
	}

	/**
	 * This is the only method that must be implemented
	 * @param BladeOne_Provider $provider The instance of BladeOne being used.
	 */
	public function config( BladeOne_Provider $provider ): void {
		$provider->setInjectResolver(
			function ( $class_name, $variable_name ) {
				return $this->app->get_container()->create( $class_name );
			}
		);

		$provider->directive(
			'i18n',
			function ( string $expression ) {
				return "<?php echo __({$expression}, 'pc_stock_man'); ?>";
			}
		);

	}
}
