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

abstract class Location_Type {

	/** @type \WP_Term */
	private $term;

	/**
	 * Constructor.
	 *
	 * @param \WP_Term $term
	 */
	public function __construct( \WP_Term $term ) {
		$this->term = $term;
	}

	/**
	 * Get the term ID.
	 *
	 * @return int
	 */
	public function get_id(): int {
		return $this->term->term_id;
	}

	/**
	 * Get the term name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return $this->term->name;
	}

	/**
	 * Get the term slug.
	 *
	 * @return string
	 */
	public function get_slug(): string {
		return $this->term->slug;
	}

	/**
	 * Get the term instance.
	 *
	 * @return WP_Term
	 */
	public function get_term(): \WP_Term {
		return $this->term;
	}

	/**
	 * Get the term parent.
	 *
	 * @return int
	 */
	public function get_parent(): int {
		return $this->term->parent;
	}

}
