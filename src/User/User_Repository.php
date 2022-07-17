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

use PinkCrab\Stock_Management\User\User;

class User_Repository {

	/**
	 * Finds a user based on the user id.
	 *
	 * @param int $user_id
	 * @return User|null
	 */
	public function find_by_id( int $user_id ): ?User {
		$wp_user = get_user_by( 'id', $user_id );
		if ( $wp_user ) {
			return new User( $wp_user );
		}
		return null;
	}

	/**
	 * Find a user by email
	 *
	 * @param string $email
	 * @return User|null
	 */
	public function find_by_email( string $email ): ?User {
		$wp_user = get_user_by( 'email', $email );
		if ( $wp_user ) {
			return new User( $wp_user );
		}
		return null;
	}

	/**
	 * Get the current logged in user
	 *
	 * @return User|null
	 */
	public function get_current_user(): ?User {
		if ( is_user_logged_in() ) {
			return new User(
				wp_get_current_user()
			);
		}
		return null;
	}
}
