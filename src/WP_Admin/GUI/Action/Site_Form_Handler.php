<?php

declare( strict_types=1 );

/**
 * Form handler for all Location:: site routes.
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

namespace PinkCrab\Stock_Management\WP_Admin\GUI\Action;

use PC_Woo_Stock_Man\PinkCrab\Nonce\Nonce;
use PC_Woo_Stock_Man\Awurth\SlimValidation\Validator;
use PinkCrab\Stock_Management\WP_Admin\GUI\Link_Maker;
use PC_Woo_Stock_Man\Respect\Validation\Validator as V;
use PinkCrab\Stock_Management\Location\Location_Repository;
use PC_Woo_Stock_Man\Psr\Http\Message\ServerRequestInterface;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;
use PinkCrab\Stock_Management\WP_Admin\GUI\Notification\Notifications;
use PinkCrab\Stock_Management\WP_Admin\GUI\Route\Locations_Site_Route;

class Site_Form_Handler {

	public const FORM_NONCE = 'site_form_nonce';

	private ServerRequestInterface $request;
	private Location_Repository $locations;
	private string $route = Locations_Site_Route::ROUTE_SLUG;
	private Nonce $nonce;
	private Validator $validator;
	private Notifications $notifications;
	private Plugin_Settings $settings;


	public function __construct(
		ServerRequestInterface &$request,
		Location_Repository $locations,
		Validator $validator,
		Plugin_Settings $settings
	) {
		$this->request       = $request;
		$this->locations     = $locations;
		$this->validator     = $validator;
		$this->nonce         = new Nonce( self::FORM_NONCE );
		$this->notifications = new Notifications();
		$this->settings      = $settings;
	}

	/**
	 * Gets the notifications.
	 *
	 * @return Notifications
	 */
	public function get_notifications(): Notifications {
		return $this->notifications;
	}

	/**
	 * Handles the create request.
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function create():bool {
		// Get the post data.
		$post_data = $this->request->getParsedBody();

		// Check its the correct gui_route and gui_action
		if ( ! is_array( $post_data )
		|| ! array_key_exists( 'form_nonce', $post_data )
		|| ! $this->nonce->validate( $post_data['form_nonce'] )
		|| ! array_key_exists( 'gui_route', $post_data )
		|| $post_data['gui_route'] !== $this->route
		|| ! array_key_exists( 'gui_action', $post_data )
		|| $post_data['gui_action'] !== 'create'
		) {
			return false;
		}

		// Validate the request data.
		$validation_rules = array(
			'site_name'    => V::notEmpty()->length( 20, 256 ),
			'site_ref'     => V::optional( V::notEmpty()->length( 100, 256 ) ),
			'site_barcode' => V::optional( V::notEmpty()->length( 100, 256 ) ),
			'site_icon'    => V::optional( V::notEmpty()->numeric() ),
		);

		$this->validator->request( $this->request, $validation_rules, 'create' );

		// Verify the request is valid.
		if ( ! $this->validator->isValid() ) {
			foreach ( $this->validator->getErrors( 'create' ) as $field => $errors ) {
				foreach ( $errors as $error ) {
					$this->notifications->error( $error, $field );
				}
			}

			return false;
		}

		// Create the location.
		$location = $this->locations->create_site(
			\sanitize_text_field( $this->validator->getValue( 'site_name', 'create' ) ),
			\sanitize_text_field( $this->validator->getValue( 'site_ref', 'create' ) ),
			\sanitize_text_field( $this->validator->getValue( 'site_barcode', 'create' ) ),
			\sanitize_text_field( $this->validator->getValue( 'site_icon', 'create' ) )
		);

		// If we have any errors.
		if ( $this->locations->has_errors() ) {
			foreach ( $this->locations->get_errors() as $location_errors ) {
				foreach ( $location_errors as $location_error ) {
					$this->notifications->error( $location_error, 'create' );
				}
			}
			return false;
		}

		// Redirect to single view.
		$redirect_to = Link_Maker::for( $this->settings->app_config()->admin_slugs->location )
			->route( 'sites' )
			->param( 'location_id', \strval( $location->id() ) );

		wp_safe_redirect( \esc_url( $redirect_to ) );
		exit;

	}
}
