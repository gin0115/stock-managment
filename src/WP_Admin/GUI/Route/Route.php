<?php

declare( strict_types=1 );

/**
 * Admin GUI Route interface.
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

namespace PinkCrab\Stock_Management\WP_Admin\GUI\Route;

use PinkCrab\Stock_Management\WP_Admin\GUI\View_Model;

interface Route {

	/**
	 * Returns the WP Page slug.
	 *
	 * @return string
	 */
	public function get_page_slug(): string;

	/**
	 * Returns the base slug for the route.
	 *
	 * @return string
	 */
	public function get_route_slug(): string;

	/**
	 * Return all on load events.
     * These are run before the routing is initiated.
	 *
	 * @return array<string, callable>
	 */
	public function on_load_events(): array;

	/**
	 * Returns the index (list) view path.
	 *
	 * @return View_Model|null
	 */
	public function index_view(): ?View_Model;


	/**
	 * Returns the create view path.
	 *
	 * @return View_Model|null
	 */
	public function create_view(): ?View_Model;

	/**
	 * Returns the edit view path.
	 *
	 * @return View_Model|null
	 */
	public function edit_view(): ?View_Model;

	/**
	 * Returns the delete view path.
	 *
	 * @return View_Model|null
	 */
	public function delete_view(): ?View_Model;


}
