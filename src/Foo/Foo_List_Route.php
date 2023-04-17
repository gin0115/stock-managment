<?php
declare( strict_types=1 );

/**
 * Controller for the stock location page.
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

namespace PinkCrab\Stock_Management\Foo;

use PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\View;
use PinkCrab\Perique_Page_Router\Route\Abstract_Index_Route;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\View_Model;

class Foo_List_Route extends Abstract_Index_Route {

	/** @inheritDoc */
	public function preload_actions(): array {
		return array(
			function() {
				// Do something
				dump('CALLED');
			},
		);
	}

	/** @inheritDoc */
	public function view_model(): View_Model {
		return new View_Model( 'views.foo-list' );
	}

	/** @inheritDoc */
	public function slug(): string {
		return 'foo-list';
	}
}
