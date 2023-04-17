<?php

declare( strict_types=1 );

/**
 * Base location type model.
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

namespace PinkCrab\Stock_Management\Location\Model;

use PinkCrab\Stock_Management\I18n\Json_Serialize_Translation_Trait;

abstract class Location implements \JsonSerializable {

	use Json_Serialize_Translation_Trait;

	public const TYPE_SITE  = 'site';
	public const TYPE_ISLE  = 'aisle'; // TYPO!
	public const TYPE_AISLE = 'aisle';
	public const TYPE_BIN   = 'bin';

	private int $id;
	private int $parent;
	private int $term_id;
	private string $type;

	private string $name;
	private ?string $ref;

	private ?string $icon;
	private ?string $barcode;
	private ?\stdClass $details;

	/**
	 * Create instance of Location.
	 *
	 * @param int $id
	 * @param int $parent
	 * @param int $term_id
	 * @param string $type
	 * @param string $name
	 * @param string $ref
	 * @param string $icon
	 * @param string $barcode
	 * @param \stdClass $details
	 */
	public function __construct(
		int $id,
		int $parent,
		int $term_id,
		string $type,
		string $name,
		?string $ref = '',
		?string $icon = '',
		?string $barcode = '',
		?\stdClass $details = null
	) {
		$this->id      = $id;
		$this->parent  = $parent;
		$this->term_id = $term_id;
		$this->type    = $type;
		$this->name    = $name;
		$this->ref     = $ref;
		$this->icon    = $icon;
		$this->barcode = $barcode;
		$this->details = $details ?? new \stdClass();
	}

	/**
	 * Get the location ID.
	 *
	 * @return int
	 */
	public function id(): int {
		return $this->id;
	}

	/**
	 * Get the location parent.
	 *
	 * @return int
	 */
	public function parent(): int {
		return $this->parent;
	}

	/**
	 * Get the location term ID.
	 *
	 * @return int
	 */
	public function term_id(): int {
		return $this->term_id;
	}

	/**
	 * Get the location type.
	 *
	 * @return string
	 */
	public function type(): string {
		return $this->type;
	}

	/**
	 * Get the location name.
	 *
	 * @return string
	 */
	public function name(): string {
		return $this->name;
	}

	/**
	 * Get the location reference.
	 *
	 * @return string
	 */
	public function ref(): string {
		return $this->ref ?? '';
	}

	/**
	 * Get the location icon.
	 *
	 * @return string
	 */
	public function icon(): string {
		return $this->icon ?? '';
	}

	/**
	 * Get the location barcode.
	 *
	 * @return string
	 */
	public function barcode(): string {
		return $this->barcode ?? '';
	}

	/**
	 * Get the location details.
	 *
	 * @return \stdClass
	 */
	public function details(): \stdClass {
		return $this->details ?? '';
	}

	/**
	 * Get the term
	 *
	 * @return \WP_Term
	 */
	public function term(): \WP_Term {
		return get_term( $this->term_id );
	}

}
