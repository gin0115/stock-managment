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
 * @view bootstrap.link
 */
class Link extends Abstract_Element {


	private string $contents;

	public function __construct( string $contents, array $attributes = array() ) {
		$this->contents = \wp_kses_post( $contents );
		$this->set_attributes( $attributes );
	}

	/**
	 * Renders a link as a nav item
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function nav_item( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'nav-link' ) ) );
	}

	/**
	 * Renders a link as a button
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function button( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'btn btn-primary' ) ) );
	}

	/**
	 * Renders a link as a stretched button
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function stretched_button( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'btn btn-primary btn-block' ) ) );
	}

	/**
	 * Renders a primary coloured link
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function primary( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'link-primary' ) ) );
	}

	/**
	 * Renders a secondary coloured link
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function secondary( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'link-secondary' ) ) );
	}

	/**
	 * Renders a success coloured link
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function success( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'link-success' ) ) );
	}

	/**
	 * Renders a danger coloured link
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function danger( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'link-danger' ) ) );
	}

	/**
	 * Renders a warning coloured link
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function warning( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'link-warning' ) ) );
	}

	/**
	 * Renders a info coloured link
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function info( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'link-info' ) ) );
	}

	/**
	 * Renders a light coloured link
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function light( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'link-light' ) ) );
	}

	/**
	 * Renders a dark coloured link
	 *
	 * @param string $contents
	 * @param array<string, string|int|float> $attributes
	 * @return self
	 */
	public static function dark( string $contents, array $attributes = array() ): self {
		return new self( $contents, self::merge_attributes( $attributes, array( 'class' => 'link-dark' ) ) );
	}
}
