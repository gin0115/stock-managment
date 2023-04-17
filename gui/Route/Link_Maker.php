<?php

declare( strict_types=1 );

/**
 * Class for creating links to admin pages.
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
 * @package PinkCrab\Perique_Page_Router
 */

namespace PinkCrab\Perique_Page_Router;

use Stringable;

class Link_Maker implements Stringable {

	private $page_slug;
	private $route;
	private $action;
	private array $additional_params = array();

	protected function __construct( string $page_slug ) {
		$this->page_slug = $page_slug;
	}

	/**
	 * Static constructor
	 *
	 * @param string $page_slug
	 * @return self
	 */
	public static function for( string $page_slug ): self {
		return new self( $page_slug );
	}

	/**
	 * Add the route.
	 *
	 * @param string $route
	 * @return self
	 */
	public function route( string $route ): self {
		$this->route = $route;
		return $this;
	}

	/**
	 * Adds a param to the URL.
	 *
	 * @param string $key
	 * @param string $value
	 * @return self
	 */
	public function param( string $key, string $value ): self {
		$this->additional_params[ $key ] = $value;
		return $this;
	}

	/**
	 * Add the action.
	 *
	 * @param string $action
	 * @return self
	 */
	public function action( string $action ): self {
		$this->action = $action;
		return $this;
	}

	/**
	 * Returns the parsed link
	 *
	 * @return string
	 */
	public function get(): string {
		$base_url = \admin_url( 'admin.php?page=' . $this->page_slug );
		// Append keys if set.
		$route  = $this->route ? "&gui_route={$this->route}" : '';
		$action = $this->action ? "&gui_action={$this->action}" : '';

		return \sprintf( '%s%s%s%s', $base_url, $route, $action, $this->compile_additional_params() );
	}

	/**
	 * Compile additional params into a string.
	 *
	 * @return string
	 */
	protected function compile_additional_params(): string {
		$params = '';
		foreach ( $this->additional_params as $key => $value ) {
			$params .= "&{$key}={$value}";
		}
		return $params;
	}

	/**
	 * Stringable implementation
	 *
	 * @return string
	 */
	public function __toString(): string {
		return $this->get();
	}
}
