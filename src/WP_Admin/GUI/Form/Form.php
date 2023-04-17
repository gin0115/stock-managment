<?php

declare( strict_types=1 );

/**
 * Form helper class.
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

namespace PinkCrab\Stock_Management\WP_Admin\GUI\Form;

use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface;
use PinkCrab\Stock_Management\WP_Admin\GUI\Notification\Notifications;

class Form {
	private Notifications $notifications;
	private string $group      = '';
	private bool $is_submitted = false;
	private array $fields      = array();

	public function __construct(
		Notifications $notifications,
		ServerRequestInterface $request,
		string $group = '',
		bool $is_submitted = false
	) {
		$this->notifications = $notifications;
		$this->is_submitted  = $is_submitted;
		$this->group         = $group;
		$this->set_fields( $request );
	}

	/**
	 * Set form fields.
	 *
	 * @return void
	 */
	public function set_fields( ServerRequestInterface $request ): void {
		$this->fields = $request->getMethod() === 'POST'
			? $request->getParsedBody()
			: $request->getQueryParams();
	}

	/**
	 * Get the Notifications instance.
	 *
	 * @return Notifications
	 */
	public function get_notifications(): Notifications {
		return $this->notifications;
	}

	/**
	 * Has the form been submitted.
	 *
	 * @return bool
	 */
	public function is_submitted(): bool {
		return $this->is_submitted;
	}

	/**
	 * Checks if a key exists in the errors.
	 *
	 * @param string $key
	 * @return bool
	 */
	public function has_error( string $key ): bool {
		// If form has not been submitted, no errors.
		if ( ! $this->is_submitted() ) {
			return false;
		}

		return count( $this->get_errors( $key ) ) > 0;
	}

	/**
	 * Gets all the errors for a key.
	 *
	 * @param string $key
	 * @return array<string>
	 */
	public function get_errors( string $key ): array {
		return $this->notifications->get_errors( $key );
	}

	/**
	 * Get the previous value.
	 *
	 * @param string $key
	 * @return string
	 */
	public function get_value( string $key ): string {
		return $this->fields[ $key ] ?? '';
	}
}
