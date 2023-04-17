<?php

declare( strict_types=1 );

/**
 * Location Taxonomy
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

namespace PinkCrab\Stock_Management\Location;

use PinkCrab\Stock_Management\Location\Model\Location;
use PinkCrab\Stock_Management\Location\Model\Location_Isle;
use PinkCrab\Stock_Management\Location\Model\Location_Site;
use PC_Woo_Stock_Man\Pixie\QueryBuilder\QueryBuilderHandler;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;

class Location_Repository {

	private QueryBuilderHandler $query;
	private Plugin_Settings $settings;
	private array $errors;

	public function __construct( QueryBuilderHandler $query, Plugin_Settings $settings ) {
		$this->settings = $settings;
		$this->query    = $query;
	}

	/**
	 * Resets the errors.
	 *
	 * @return void
	 */
	private function reset_errors(): void {
		$this->errors = array();
	}

	/**
	 * Returns the errors.
	 *
	 * @return array
	 */
	public function get_errors(): array {
		return $this->errors;
	}

	/**
	 * Checks if has errors.
	 *
	 * @return bool
	 */
	public function has_errors(): bool {
		return ! empty( $this->errors );
	}

	/**
	 * Adds an error to the errors array.
	 *
	 * @param string $error
	 * @return void
	 */
	private function add_error( string $error ): void {
		$this->errors[] = $error;
	}


	public function maybe_json_decode_as_object( $value, $fallback ) {
		$decoded = json_decode( $value );

		if ( is_object( $decoded ) ) {
			return $decoded;
		}
		return $fallback;
	}

	/**
	 * Finds a site based om its ID.
	 *
	 * @param int $id
	 * @return Location_Site|null
	 */
	public function find( int $id ): ?Location_Site {
		$this->reset_errors();

		$site = $this->query->table( $this->settings->app_config()->db_tables( 'location' ) )
			->where( 'id', $id )
			->first();

		if ( ! $site ) {
			$this->add_error( 'Site not found' );
			return null;
		}

		return new Location_Site(
			(int) $site->id,
			(int) $site->parent,
			(int) $site->term_id,
			$site->type,
			$site->name,
			$site->ref,
			$site->icon,
			$site->barcode,
			$this->maybe_json_decode_as_object( $site->details, null ),
		);
	}

	/**
	 * Get all location sites.
	 *
	 * @return Location_Site[]
	 */
	public function get_all_sites(): array {
		$sites = $this->query
		->table( $this->settings->app_config()->db_tables( 'location' ) )
		->select( '*' )
		->where( 'type', Location::TYPE_SITE )
		->get();

		return array_map(
			fn ( \stdClass $site ): Location_Site => new Location_Site(
				(int) $site->id,
				(int) $site->parent,
				(int) $site->term_id,
				$site->type,
				$site->name,
				$site->ref,
				$site->icon,
				$site->barcode,
				$this->maybe_json_decode_as_object( $site->details, null ),
			),
			$sites
		);
	}

	/**
	 * Get all isles for a site.
	 *
	 * @param Location_Site $site
	 * @return Location_Isle[]
	 */
	public function get_aisles_for_site( Location_Site $site ): array {
		$isles = $this->query
		->table( $this->settings->app_config()->db_tables( 'location' ) )
		->select( '*' )
		->where( 'type', Location::TYPE_ISLE )
		->where( 'parent', $site->id() )
		->get();

		return array_map(
			fn ( \stdClass $isle ): Location_Isle => new Location_Isle(
				(int) $isle->id,
				(int) $isle->parent,
				(int) $isle->term_id,
				$isle->type,
				$isle->name,
				$isle->ref,
				$isle->icon,
				$isle->barcode,
				$this->maybe_json_decode_as_object( $isle->details, null ),
			),
			$isles ?? array()
		);
	}

	/**
	 * Get all locations.
	 *
	 * @return array
	 */
	public function get_all(): array {
		$isles = $this->query
		->table( $this->settings->app_config()->db_tables( 'location' ) )
		->select( '*' )
		->get();

		return array_map(
			function ( $isle ) {
				return (int) $isle->parent === 0
					? new Location_Site(
						(int) $isle->id,
						(int) $isle->parent,
						(int) $isle->term_id,
						$isle->type,
						$isle->name,
						$isle->ref,
						$isle->icon,
						$isle->barcode,
						$this->maybe_json_decode_as_object( $isle->details, null ),
					)
					: new Location_Isle(
						(int) $isle->id,
						(int) $isle->parent,
						(int) $isle->term_id,
						$isle->type,
						$isle->name,
						$isle->ref,
						$isle->icon,
						$isle->barcode,
						$this->maybe_json_decode_as_object( $isle->details, null ),
					);
			},
			$isles ?? array()
		);
		return array(
			array(
				'name'        => 'Site A',
				'term_id'     => 25,
				'parent'      => 0,
				'description' => 'This is the first location',
				'children'    => array(
					array(
						'name'        => 'Site A - Location A',
						'term_id'     => 13,
						'parent'      => 12,
						'description' => 'This is the first location',
						'children'    => array(
							array(
								'name'        => 'Site A - Location A - Location A',
								'term_id'     => 14,
								'parent'      => 13,
								'description' => 'This is the first location',
							),
						),
					),
					array(
						'name'        => 'Site A - Location B',
						'term_id'     => 17,
						'parent'      => 12,
						'description' => 'This is the first location',
						'children'    => array(
							array(
								'name'        => 'Site A - Location B - Location A',
								'term_id'     => 19,
								'parent'      => 17,
								'description' => 'This is the first location',
							),
						),
					),
				),
			),
			array(
				'name'        => 'Site B',
				'term_id'     => 45,
				'parent'      => 0,
				'description' => 'This is the second location',
				'children'    => array(
					array(
						'name'        => 'Site B - Location A',
						'term_id'     => 46,
						'parent'      => 45,
						'description' => 'This is the second location',
						'children'    => array(
							array(
								'name'        => 'Site B - Location A - Location A',
								'term_id'     => 47,
								'parent'      => 46,
								'description' => 'This is the second location',
							),
						),
					),
					array(
						'name'        => 'Site B - Location B',
						'term_id'     => 49,
						'parent'      => 45,
						'description' => 'This is the second location',
						'children'    => array(
							array(
								'name'        => 'Site B - Location B - Location A',
								'term_id'     => 50,
								'parent'      => 49,
								'description' => 'This is the second location',
							),
						),
					),
				),
			),
		);
	}

	/**
	 * Find site by term id.
	 *
	 * @param int $term_id
	 * @return Location_Site|null
	 */
	public function find_site_by_term_id( int $term_id ): ?Location_Site {
		$site = $this->query
		->table( $this->settings->app_config()->db_tables( 'location' ) )
		->select( '*' )
		->where( 'term_id', $term_id )
		->first();

		return $site
		? new Location_Site(
			(int) $site->id,
			(int) $site->parent,
			(int) $site->term_id,
			$site->type,
			$site->name,
			$site->ref,
			$site->icon,
			$site->barcode,
			$this->maybe_json_decode_as_object( $site->details, null ),
		)
		: null;
	}

	/**
	 * Upserts a location.
	 *
	 * @param Location $location
	 * @return Location
	 */
	public function upsert_location( Location $location ): Location {
		// Reset errors.
		$this->errors = array();

		$is_new = $location->id() === 0;

		// If new run an insert.
		$site = $this->query
			->table( $this->settings->app_config()->db_tables( 'location' ) )
			->insert(
				array(
					'parent'  => $location->parent(),
					'term_id' => $location->term_id(),
					'type'    => $location->type(),
					'name'    => $location->name(),
					'ref'     => $location->ref(),
					'icon'    => $location->icon(),
					'barcode' => $location->barcode(),
					'details' => \wp_json_encode( $location->details() ),
				)
			);

		return new Location_Site(
			$site,
			$location->parent(),
			$location->term_id(),
			$location->type(),
			$location->name(),
			$location->ref(),
			$location->icon(),
			$location->barcode(),
			$location->details(),
		);

		return $location;
	}

	/**
	 * Create new site
	 *
	 * @param string $site
	 * @param ?string $ref
	 * @param ?string $icon
	 * @param ?string $barcode
	 * @param ?object $details
	 * @return Location_Site
	 */
	public function create_site(
		string $site,
		?string $ref = null,
		?string $icon = null,
		?string $barcode = null,
		?\stdClass $details = null
	): ?Location_Site {

		// Reset errors.
		$this->errors = array();

		// Create the term first.
		$term = wp_insert_term(
			$site,
			$this->settings->location_taxonomy(),
			array( 'parent' => 0 )
		);

		// If we have an error, log and return null.
		if ( is_wp_error( $term ) ) {
			foreach ( $term->get_error_codes() as $code ) {
				$this->errors[ $code ] = $term->get_error_messages( $code );
			}
			return null;
		}

		// Create site using term.
		$site = $this->upsert_location(
			new Location_Site(
				0,
				0,
				(int) $term['term_id'],
				Location::TYPE_SITE,
				$site,
				$ref,
				$icon,
				$barcode,
				$details,
			)
		);

		// If we dont have a valid ID, log as an error.
		if ( ! $site instanceof Location_Site ) {
			// Remove the term.
			$this->errors['db'][] = 'Unable to create site';
			wp_delete_term( $term['term_id'], $this->settings->location_taxonomy() );
			return null;
		}

		return $site;
	}

}
