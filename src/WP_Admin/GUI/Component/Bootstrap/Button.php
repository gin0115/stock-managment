<?php

declare( strict_types=1 );

/**
 * Bootstrap Component
 *
 * Button
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

use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap\Abstract_Element;

/**
 * @view bootstrap.button
 */
class Button extends Abstract_Element {

	private string $contents;

	public function __construct( string $contents, array $attributes = array() ) {
		$this->contents = \wp_kses_post( $contents );
		$this->set_attributes( $attributes );
	}

		/** @inheritDoc */
	protected function base_attributes(): array {
		return array(
			'class' => 'btn',
			'type'  => 'button',
		);
	}

	/**
	 * Create a warning button
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function warning( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'btn-warning text-dark' ) ) );
	}

	/**
	 * Create a success button
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function success( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'btn-success text-light' ) ) );
	}

	/**
	 * Create a danger button
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function danger( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'btn-danger' ) ) );
	}

	/**
	 * Create a info button
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function info( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'btn-info' ) ) );
	}

	/**
	 * Create a primary button
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function primary( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'btn-primary' ) ) );
	}

	/**
	 * Create a secondary button
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function secondary( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'btn-secondary' ) ) );
	}

	/**
	 * Create a light button
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function light( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'btn-light' ) ) );
	}

	/**
	 * Create a dark button
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function dark( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'btn-dark' ) ) );
	}

	/**
	 * Create a link button
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function link( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'btn-link' ) ) );
	}

	/**
	 * Create a outline button
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function outline( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'btn-outline' ) ) );
	}

}
