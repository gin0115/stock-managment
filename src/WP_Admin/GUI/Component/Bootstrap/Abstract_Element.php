<?php

declare( strict_types=1 );

/**
 * Bootstrap Component
 *
 * Abstract class for all bootstrap components.
 *
 * Handles attribute and class parsing.
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

use PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\Component\Component;
use PC_Woo_Stock_Man\PinkCrab\FunctionConstructors\Arrays as Arr;

abstract class Abstract_Element extends Component {

	protected string $attributes;

	/**
	 * Merges attributes together
	 * If class is present in either, concat with whitespace.
	 *
	 * @param array<string, string|int|float> $array1
	 * @param array<string, string|int|float> $array2
	 * @return array<string, string|int|float>
	 */
	protected static function merge_attributes( array $array1, array $array2 ): array {
		// Merge 2 arrays, but if both contain class key, concate value with whitespace between.
		if ( isset( $array1['class'] ) && isset( $array2['class'] ) ) {
			$array1['class'] .= ' ' . $array2['class'];
			unset( $array2['class'] );
		}
		return array_merge( $array1, $array2 );
	}

	/**
	 * Returns the base attributes.
	 *
	 * @return array<string, string|int|float>
	 */
	protected function base_attributes(): array {
		return array();
	}

	/**
	 * Sets the attributes for the button group.
	 *
	 * @param array<string, string|int|float> $attributes
	 * @return mixed
	 */
	protected function set_attributes( array $attributes ): void {
		$base = $this->base_attributes();

		$attributes = self::merge_attributes( $base, $attributes );

		// Replace all defaults with attributes.
		$this->attributes = join(
			' ',
			Arr\mapWithKey(
				function( $key, $value ): string {
					return esc_attr( $key ) . '="' . esc_html( $value ) . '"';
				}
			)( $attributes )
		);

	}
}
