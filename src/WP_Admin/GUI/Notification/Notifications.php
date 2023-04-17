<?php

declare( strict_types=1 );

/**
 * Collection of notifications to be displayed on the admin page.
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

namespace PinkCrab\Stock_Management\WP_Admin\GUI\Notification;

class Notifications {

	public const SUCCESS = 'success';
	public const ERROR   = 'error';
	public const WARNING = 'warning';
	public const INFO    = 'info';


	/** @var array<string, string[]> */
	private array $notifications = array();

	/**
	 * Adds a notification to the collection.
	 *
	 * @param string $type
	 * @param string $message
	 * @param string $group
	 * @return $this
	 */
	public function add( string $type, string $message, string $group = '' ): self {
		if ( ! isset( $this->notifications[ $type ] ) ) {
			$this->notifications[ $type ] = array();
		}
		$this->notifications[ $type ][ $group ][] = $message;
		return $this;
	}

	/**
	 * Add a success notification.
	 *
	 * @param string $message
	 * @param string $group
	 * @return $this
	 */
	public function success( string $message, string $group = '' ): self {
		return $this->add( self::SUCCESS, $message, $group );
	}

	/**
	 * Add a error notification.
	 *
	 * @param string $message
	 * @param string $group
	 * @return $this
	 */
	public function error( string $message, string $group = '' ): self {
		return $this->add( self::ERROR, $message, $group );
	}

	/**
	 * Add a warning notification.
	 *
	 * @param string $message
	 * @param string $group
	 * @return $this
	 */
	public function warning( string $message, string $group = '' ): self {
		return $this->add( self::WARNING, $message, $group );
	}

	/**
	 * Add a info notification.
	 *
	 *  @param string $message
	 * @param string $group
	 * @return $this
	 */
	public function info( string $message, string $group = '' ): self {
		return $this->add( self::INFO, $message, $group );
	}

	/**
	 * Get all notifications.
	 *
	 * @return array<string, string[]>
	 */
	public function get(): array {
		return $this->notifications;
	}

	/**
	 * Get all notifications of a specific type.
	 *
	 * @param string $type
	 * @return string[]
	 */
	public function get_by_type( string $type, string $group = '' ): array {
		if ( ! array_key_exists( $type, $this->notifications ) ) {
			return array();
		}

		// If group is empty, return all groups.
		if ( empty( $group ) ) {
			return $this->notifications[ $type ];
		}

		if ( ! array_key_exists( $group, $this->notifications[ $type ] ) ) {
			return array();
		}

		return $this->notifications[ $type ][ $group ];
	}

	/**
	 * Checks if there are any notifications.
	 *
	 * @return bool
	 */
	public function has(): bool {
		return ! empty( $this->notifications );
	}

	/**
	 * Checks if there are any notifications of a specific type.
	 *
	 * @param string $type
	 * @return bool
	 */
	public function has_by_type( string $type, string $group = '' ): bool {
		return ! empty( $this->notifications[ $type ] )
			? ! empty( $this->notifications[ $type ][ $group ] )
			: false;
	}

	/**
	 * Checks if there are any warnings.
	 *
	 * @return bool
	 */
	public function has_warnings( string $group = '' ): bool {
		return $this->has_by_type( self::WARNING, $group );
	}

	/**
	 * Checks if there are any errors.
	 *
	 * @return bool
	 */
	public function has_errors( string $group = '' ): bool {
		return $this->has_by_type( self::ERROR, $group );
	}

	/**
	 * Checks if there are any success messages.
	 *
	 * @return bool
	 */
	public function has_success( string $group = '' ): bool {
		return $this->has_by_type( self::SUCCESS, $group );
	}

	/**
	 * Checks if there are any info messages.
	 *
	 * @return bool
	 */
	public function has_info( string $group = '' ): bool {
		return $this->has_by_type( self::INFO, $group );
	}

	/**
	 * Get all warnings.
	 *
	 * @return string[]
	 */
	public function get_warnings(): array {
		return $this->get_by_type( self::WARNING );
	}

	/**
	 * Get all errors.
	 *
	 * @return string[]
	 */
	public function get_errors( string $group = '' ): array {
		return $this->get_by_type( self::ERROR, $group );
	}

	/**
	 * Get all success messages.
	 *
	 * @return string[]
	 */
	public function get_success(): array {
		return $this->get_by_type( self::SUCCESS );
	}

	/**
	 * Get all info messages.
	 *
	 * @return string[]
	 */
	public function get_info(): array {
		return $this->get_by_type( self::INFO );
	}
}
