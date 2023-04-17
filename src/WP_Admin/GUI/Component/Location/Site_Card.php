<?php

declare( strict_types=1 );

/**
 * Site Card Component for the Stock Management Admin GUI.
 * Location section
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

namespace PinkCrab\Stock_Management\WP_Admin\GUI\Component\Location;

use PinkCrab\Stock_Management\Location\Model\Location_Site;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap\Link;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\Component\Component;
use PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap\Button_Group;

/**
 * @view locations.site-card
 */
class Site_Card extends Component {

	private Location_Site $site;

	private array $aisles;

	private int $product_count;

	private Button_Group $button_group;

	public function __construct( Location_Site $site, array $aisles, int $product_count ) {
		$this->site          = $site;
		$this->aisles        = $aisles;
		$this->product_count = $product_count;

		$this->button_group = new Button_Group(
			array(
				new Link(
					'Edit',
					array(
						'class' => 'btn btn-primary',
						'href'  => admin_url( 'admin.php?page=pc' ) . '&action=edit&site_id=' . $site->id(),
					)
				),
				new Link(
					'Delete',
					array(
						'class' => 'btn btn-danger',
						'href'  => admin_url( 'admin.php?page=pc' ) . '&action=delete&site_id=' . $site->id(),
					)
				),
			)
		);
	}

}
