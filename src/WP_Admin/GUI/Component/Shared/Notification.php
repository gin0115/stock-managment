<?php

declare( strict_types=1 );

/**
 * Renders all notifcations from a Notification instance.
 * Shared section
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

namespace PinkCrab\Stock_Management\WP_Admin\GUI\Component\Shared;

use PinkCrab\Stock_Management\WP_Admin\GUI\Notification\Notifications;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\Component\Component;

/**
 * @view shared.notification
 */
class Notification extends Component {

	private array $warnings  = array();
	private array $infos     = array();
	private array $successes = array();
	private array $errors    = array();

	private string $position;

	public function __construct( Notifications $notifications, string $position = 'top' ) {
		$this->warnings  = $notifications->get_warnings();
		$this->infos     = $notifications->get_info();
		$this->successes = $notifications->get_success();
		$this->errors    = $notifications->get_errors();
		$this->position  = $position;
	}
}
