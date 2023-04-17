<?php

declare( strict_types=1 );

/**
 * Shared auth middleware.
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

namespace PinkCrab\Stock_Management\Rest;

use Closure;

class Rest_Auth {
		/**
	 * Allows the passing of multiple checks where all must pass.
	 *
	 * @param callable(\WP_REST_Request):bool ...$closures
	 * @return callable(\WP_REST_Request):bool
	 */
	public function multiple_all( callable ...$closures ): callable {
		return function( \WP_REST_Request $request ) use ( $closures ): bool {
			foreach ( $closures as $closure ) {
				// If any fail, just end a failed.
				if ( false === $closure( $request ) ) {
					return false;
				}
			}

			// None failed, so pass.
			return true;
		};
	}

	/**
	 * Allows the passing of multiple checks where any must pass.
	 *
	 * @param callable(\WP_REST_Request):bool ...$closures
	 * @return callable(\WP_REST_Request):bool
	 */
	public function multiple_any( callable ...$closures ): callable {
		return function( \WP_REST_Request $request ) use ( $closures ): bool {

			// If any pass, just end as a pass.
			foreach ( $closures as $closure ) {
				if ( true === $closure( $request ) ) {
					return true;
				}
			}

			// None passed, so fail.
			return false;
		};
	}

	/**
	 * Returns a callable that authenticates the user is logged in and is a teacher.
	 *
	 * @return callable(\WP_REST_Request $request): bool
	 */
	public function is_logged_in(): callable {

		/**
		 * @param \WP_REST_Request $request The incoming request
		 * @return bool
		 */
		return function( \WP_REST_Request $request ): bool { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
			if ( ! \is_user_logged_in() ) {
				return false;
			}

			return true;
		};
	}

	/**
	 * Returns a callable that  authenticates the user is logged in and has the passed role.
	 *
	 * @param string $role The role checking the logged in user has.
	 * @return callable(\WP_REST_Request $request): bool
	 */
	public function is_role( string $role ): callable {
		/**
		 * @param \WP_REST_Request $request The incoming request
		 * @return bool
		 */
		return function( \WP_REST_Request $request ) use ( $role ): bool { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
			if ( ! \is_user_logged_in() ) {
				return false;
			}

			// Get all roles for user.
			$roles = (array) \wp_get_current_user()->roles;

			return in_array( $role, $roles, true );
		};
	}

	/**
	 * Checks that the user is logged in and an admin.
	 *
	 * @return \Closure
	 */
	public function is_logged_in_admin(): Closure {
		return $this->multiple_all(
			$this->is_logged_in(),
			$this->is_role( 'administrator' )
		);
	}
}

