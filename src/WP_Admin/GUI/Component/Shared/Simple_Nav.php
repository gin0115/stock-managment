<?php

declare( strict_types=1 );

/**
 * Simple 2 column nav.
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

use PinkCrab\Stock_Management\Location\Model\Location_Site;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap\Link;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap\Button;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\Component\Component;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap\Button_Group;

/**
 * @view shared.simple-nav
 */
class Simple_Nav extends Component {

	/** @var Link|Button */
	private $title;

	/** @var array<int, Link|Button> */
	private array $links;

	private string $wrapper_class;

	public function __construct( $title, array $links, string $wrapper_class = 'bg-dark text-white' ) {
		$this->title         = $title;
		$this->links         = $links;
		$this->wrapper_class = $wrapper_class;
	}
}
