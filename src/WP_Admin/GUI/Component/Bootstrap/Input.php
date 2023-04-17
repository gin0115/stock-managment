<?php

declare( strict_types=1 );

/**
 * Renders an input field.
 *
 * Form section
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

/**
 * @view bootstrap.input_field
 */
class Input extends Abstract_Element {

	private string $name;
	private string $type;
	private array $errors;
	private ?string $label = null;

	public function __construct( string $name, string $type, array $attributes = array(), array $errors = array() ) {
		$this->name   = esc_attr( $name );
		$this->type   = esc_attr( $type );
		$this->errors = $errors;
		$this->set_attributes( $attributes );
	}

	/** @inheritDoc */
	protected function base_attributes(): array {
		$attributes = array(
			'type'  => $this->type,
			'class' => 'form-control',
		);

		// If we have errors, add the error class.
		if ( ! empty( $this->errors ) ) {
			$attributes['class'] .= ' is-invalid';
		}

		return $attributes;
	}

	/**
	 * Adds an error.
	 *
	 * @param string ...$error
	 * @return void
	 */
	public function add_error( string ...$error ): void {
		$this->errors = array_merge( $this->errors, $error );
	}

	/**
	 * Sets the label.
	 *
	 * @param string $label
	 * @return static
	 */
	public function set_label( string $label ): self {
		$this->label = $label;
		return $this;
	}

	/**
	 * Static constructor for Text input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function text( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'text', $attributes, $errors );
	}

	/**
	 * Static constructor for Password input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function password( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'password', $attributes, $errors );
	}

	/**
	 * Static constructor for Email input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function email( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'email', $attributes, $errors );
	}

	/**
	 * Static constructor for Number input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function number( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'number', $attributes, $errors );
	}

	/**
	 * Static constructor for Checkbox input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function checkbox( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'checkbox', $attributes, $errors );
	}

	/**
	 * Static constructor for Radio input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function radio( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'radio', $attributes, $errors );
	}

	/**
	 * Static constructor for Hidden input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function hidden( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'hidden', $attributes, $errors );
	}

	/**
	 * Static constructor for Date input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function date( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'date', $attributes, $errors );
	}

	/**
	 * Static constructor for Time input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function time( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'time', $attributes, $errors );
	}

	/**
	 * Static constructor for Datetime input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function datetime( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'datetime', $attributes, $errors );
	}

	/**
	 * Static constructor for Datetime-local input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function datetime_local( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'datetime-local', $attributes, $errors );
	}

	/**
	 * Static constructor for Month input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function month( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'month', $attributes, $errors );
	}

	/**
	 * Static constructor for Week input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function week( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'week', $attributes, $errors );
	}

	/**
	 * Static constructor for Color input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function color( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'color', $attributes, $errors );
	}

	/**
	 * Static constructor for Range input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function range( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'range', $attributes, $errors );
	}

	/**
	 * Static constructor for Search input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function search( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'search', $attributes, $errors );
	}

	/**
	 * Static constructor for Tel input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function tel( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'tel', $attributes, $errors );
	}

	/**
	 * Static constructor for Url input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function url( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'url', $attributes, $errors );
	}

	/**
	 * Static constructor for File input.
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param array $errors
	 * @return static
	 */
	public static function file( string $name, array $attributes = array(), array $errors = array() ): self {
		return new self( $name, 'file', $attributes, $errors );
	}

}
