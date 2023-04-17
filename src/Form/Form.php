<?php

declare( strict_types=1 );

/**
 * Form instance
 *
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
 * @package PinkCrab\Form
 */

namespace PinkCrab\Stock_Management\Form;

use Respect\Validation\Validator;
use PinkCrab\Stock_Management\Form\Field\Field;

class Form {

	/**
	 * The forms key.
	 *
	 * @var string
	 */
	protected $key;

	/**
	 * The form method
	 *
	 * @var string
	 */
	protected $method;

	/**
	 * The form action
	 *
	 * @var string
	 */
	protected $action;

	/**
	 * The forms encoding type
	 *
	 * @var ?string
	 */
	protected $enctype = null;

	/**
	 * The forms target
	 *
	 * @var ?string
	 */
	protected $target = null;

	/**
	 * The forms autocomplete
	 *
	 * @var ?string
	 */
	protected $autocomplete = null;

	/**
	 * The form fields
	 *
	 * @var Field[]
	 */
	protected $fields = array();

	/**
	 * Rules for the fields
	 *
	 * @var array<string, Validator>
	 */
	protected $validation_rules = array();

	/**
	 * The form values.
	 *
	 * @var array<string, mixed>
	 */
	protected $values = array();

	/**
	 * Creates an instance of the form.
	 *
	 * @param string $key
	 * @param string $method
	 * @param string $action
	 */
	public function __construct( string $key, string $method = '', string $action = '' ) {
		$this->key    = $key;
		$this->method = $method;
		$this->action = $action;
	}

	/**
	 * Get the form key
	 *
	 * @return string
	 */
	public function get_key(): string {
		return $this->key;
	}

	/**
	 * Get the form method
	 *
	 * @return string
	 */
	public function get_method(): string {
		return $this->method;
	}

	/**
	 * Get the form action
	 *
	 * @return string
	 */
	public function get_action(): string {
		return $this->action;
	}

	/**
	 * Set the encoding type.
	 *
	 * @param string $enctype
	 * @return self
	 */
	public function enctype( string $enctype ): self {
		$this->enctype = $enctype;
		return $this;
	}

	/**
	 * Checks if the enctype is set.
	 *
	 * @return bool
	 */
	public function has_enctype(): bool {
		return ! is_null( $this->enctype );
	}

	/**
	 * Get the encoding type.
	 *
	 * @return string
	 */
	public function get_enctype(): string {
		return $this->enctype;
	}

	/**
	 * Set the target.
	 *
	 * @param string $target
	 * @return self
	 */
	public function target( string $target ): self {
		$this->target = $target;
		return $this;
	}

	/**
	 * Checks if the target is set.
	 *
	 * @return bool
	 */
	public function has_target(): bool {
		return ! is_null( $this->target );
	}

	/**
	 * Get the target.
	 *
	 * @return ?string
	 */
	public function get_target(): ?string {
		return $this->target;
	}

	/**
	 * Set the autocomplete.
	 *
	 * @param string $autocomplete
	 * @return self
	 */
	public function autocomplete( string $autocomplete ): self {
		$this->autocomplete = $autocomplete;
		return $this;
	}

	/**
	 * Checks if the autocomplete is set.
	 *
	 * @return bool
	 */
	public function has_autocomplete(): bool {
		return ! is_null( $this->autocomplete );
	}

	/**
	 * Get the autocomplete.
	 *
	 * @return ?string
	 */
	public function get_autocomplete(): ?string {
		return $this->autocomplete;
	}


	/**
	 * Adds a field to the form.
	 *
	 * @param string $key
	 * @param class-string<Field> $field
	 * @param ?callable(Field):Field $config
	 * @param ?Validator $validator
	 * @return self
	 */
	public function add_field( string $key, string $field, ?callable $config = null, ?Validator $validator = null ): self {
		$this->fields[ $key ] = new $field( $key );
		if ( $config ) {
			$this->fields[ $key ] = $config( $this->fields[ $key ] );
		}
		if ( $validator ) {
			$this->validation_rules[ $key ] = $validator;
		}
		return $this;
	}

	/**
	 * Checks if the form has a field.
	 *
	 * @param string $key
	 * @return bool
	 */
	public function has_field( string $key ): bool {
		return array_key_exists( $key, $this->fields );
	}

	/**
	 * Returns the field.
	 *
	 * @param string $key
	 * @return ?Field
	 */
	public function get_field( string $key ): ?Field {
		return $this->fields[ $key ] ?? null;
	}

	/**
	 * Get all fields.
	 *
	 * @return Field[]
	 */
	public function get_fields(): array {
		return $this->fields;
	}

	/**
	 * Add values
	 *
	 * @param array<string, mixed> $values
	 * @return self
	 */
	public function add_values( array $values ): self {
		// Iterate through values and populate the values, if key exists.
		foreach ( $values as $key => $value ) {
			if ( $this->has_field( $key ) ) {
				// Sanitize with fields sanitize method if exists.
				$this->values[ $key ] = $this->fields[ $key ]->has_sanitizer()
					? $this->fields[ $key ]->get_sanitizer()( $value )
					: $value;
			}
		}
	}

	/**
	 * Adds a single value
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return self
	 */
	public function add_value( string $key, $value ): self {
		if ( $this->has_field( $key ) ) {
			// Sanitize with fields sanitize method if exists.
			$this->values[ $key ] = $this->fields[ $key ]->has_sanitizer()
				? $this->fields[ $key ]->get_sanitizer()( $value )
				: $value;
		}
		return $this;
	}

	/**
	 * Checks if a value exists
	 *
	 * @param string $key
	 * @return bool
	 */
	public function has_value( string $key ): bool {
		return array_key_exists( $key, $this->values );
	}

	/**
	 * Gets a value
	 *
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function get_value( string $key, $default = null ) {
		return $this->has_value( $key )
			? $this->values[ $key ]
			: $default;
	}

	/**
	 * Gets all the values.
	 *
	 * @return array<string, mixed>
	 */
	public function get_values(): array {
		return $this->values;
	}

}
