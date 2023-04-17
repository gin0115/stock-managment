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

namespace PinkCrab\Perique_Page_Router\Route;


use PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\View_Model;

interface Route {

	public const INDEX  = 'index';
	public const CREATE = 'create';
	public const EDIT   = 'edit';
	public const DELETE = 'delete';
	public const SINGLE = 'single';

	/**
	 * Returns the routes slug.
	 *
	 * @return string
	 */
	public function slug(): string;

	/**
	 * Returns the route type.
	 * 
	 * @return string
	 */
	public function type(): string;

	/**
	 * Returns all actions called before the route is rendered
	 *
	 * @return array<callable>
	 */
	public function preload_actions(): array;

	/**
	 * Returns the view model for the routes view.
	 *
	 * @return View_Model
	 */
	public function view_model(): View_Model;

}
