<?php

declare( strict_types=1 );

/**
 * User model
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

namespace PinkCrab\Stock_Management\User;

use JsonSerializable;

class User implements JsonSerializable {

	/** @var int */
	private $id;

	/** @var string */
	private $email;

	/** @var string */
	private $role;

	/** @var string */
	private $name;

	/** @var \WP_User */
	private $wp_user;

	public function __construct( \WP_User $wp_user ) {
		$this->wp_user = $wp_user;
		$this->id      = $wp_user->ID;
		$this->email   = $wp_user->user_email;
		$this->role    = $wp_user->roles[0];
		$this->name    = $wp_user->display_name;
	}

	/**
	 * Get the value of id
	 * @return int
	 */
	public function get_id(): int {
		return $this->id;
	}

	/**
	 * Get the value of email
	 * @return string
	 */
	public function get_email():string {
		return $this->email;
	}

	/**
	 * Get the value of role
	 * @return string
	 */
	public function get_role(): string {
		return $this->role;
	}

	/**
	 * Get the value of name
	 * @return string
	 */
	public function get_name(): string {
		return $this->name;
	}

	/**
	 * Get the value of wp_user
	 * @return \WP_User
	 */
	public function get_wp_user(): \WP_User {
		return $this->wp_user;
	}

    /**
     * Implement JsonSerializable
     * 
     * @return array
     */
    public function jsonSerialize() {
        return [
            'id'      => $this->id,
            'email'   => $this->email,
            'role'    => $this->role,
            'name'    => $this->name,
        ];}
}
