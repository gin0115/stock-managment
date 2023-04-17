<?php

declare( strict_types=1 );

/**
 * Bootstrap Component
 *
 * Button Group
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

namespace PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap;

use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap\Link;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap\Button;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap\Abstract_Element;
use function PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Objects\{isInstanceOf};
use function PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Comparisons\{groupOr as any};

/**
 * @view bootstrap.button-group
 */
class Button_Group extends Abstract_Element {

	/** @var Button[] */
	private array $buttons;

	/**
	 * @param Button[] $buttons
	 * @param array<string, string|int|float> $attributes
	 */
	public function __construct( array $buttons, array $attributes = array() ) {
		$this->buttons = array_filter( $buttons, any( isInstanceOf( Button::class ), isInstanceOf( Link::class ) ) );
		$this->set_attributes( $attributes );
	}

	/** @inheritDoc */
	protected function base_attributes(): array {
		return array(
			'class' => 'btn-group',
			'role'  => 'group',
		);
	}

}
