<?php

declare( strict_types=1 );

/**
 * Abstract class for all Form Fields.
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

namespace PinkCrab\Stock_Management\Form\Field;

abstract class Field {

	/**
	 * The fields name.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Attributes
	 *
	 * @var array<string, string|int|float|bool|null>
	 */
	protected $attributes = array();

	/**
	 * Constructs an instance of the field.
	 *
	 * @param string $name
	 */
	public function __construct( string $name ) {
		$this->name = $name;
	}

	/**
	 * Gets the value of name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return $this->name;
	}

	/**
	 * The fields sanitization callback
	 *
	 * @var ?callable(mixed):mixed
	 */
	protected $sanitizer;

	/**
	 * Sets the sanitizer.
	 *
	 * @param ?callable(mixed):mixed $sanitizer
	 * @return self
	 */
	public function sanitizer( ?callable $sanitizer ): self {
		$this->sanitizer = $sanitizer;
		return $this;
	}

	/**
	 * Checks if the field has a sanitizer
	 *
	 * @return bool
	 */
	public function has_sanitizer(): bool {
		return ! is_null( $this->sanitizer );
	}

	/**
	 * Returns the fields sanitizer
	 *
	 * @return ?callable(mixed):mixed
	 */
	public function get_sanitizer(): ?callable {
		return $this->sanitizer;
	}

	/**
	 * Checks if the field has an attribute.
	 *
	 * @param string $attribute
	 * @return bool
	 */
	public function has_attribute( string $attribute ): bool {
		return array_key_exists( $attribute, $this->attributes );
	}

	/**
	 * Gets the value of an attribute.
	 *
	 * @param string $attribute
	 * @return string|int|float|bool|null
	 */
	public function get_attribute( string $attribute ) {
		return \array_key_exists( $attribute, $this->attributes )
			? $this->attributes[ $attribute ]
			: null;
	}

	/**
	 * Get all attributes.
	 *
	 * @return array<string, string|int|float|bool|null>
	 */
	public function get_attributes(): array {
		return $this->attributes;
	}

	/**
	 * Sets the value of an attribute.
	 *
	 * @param string $attribute
	 * @param string|int|float|bool|null $value
	 * @return self
	 */
	public function attribute( string $attribute, $value ): self {
		$this->attributes[ $attribute ] = $value;
		return $this;
	}

}
