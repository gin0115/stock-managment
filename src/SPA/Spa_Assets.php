<?php

declare( strict_types=1 );

/**
 * Service for handling all SPA assets.
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

namespace PinkCrab\Stock_Management\SPA;

use RuntimeException;

class Spa_Assets {

	/**
	 * Paths to the SPA manifest.
	 *
	 * @var string
	 */
	private $manifest;

	/**
	 * The uri to the JS asset files.
	 *
	 * @var string
	 */
	private $build_uri;

	/**
	 * Constructor.
	 *
	 * @param string $manifest   Path to the SPA manifest.
	 * @param string $build_uri  Url to the JS asset files.
	 */
	public function __construct( string $manifest, string $build_uri ) {
		$this->manifest  = $manifest;
		$this->build_uri = $build_uri;
	}

	/**
	 * Decodes the Manifest and returns the contents.
	 * @return object
	 * @throws RuntimeException
	 * @throws RuntimeException
	 */
	private function get_manifest(): object {
		$manifest = json_decode( file_get_contents( $this->manifest ) );
		if ( ! is_object( $manifest ) || ! property_exists( $manifest, 'index.html' ) ) {
			throw new \RuntimeException( 'Invalid SPA manifest.' );
		}
		return $manifest;
	}

	/**
	 * Gets the full URI for the given asset from manifest.
	 *
	 * @param string $type
	 * @return string[]
	 */
	private function get_asset_uri( string $type ): array {
		$manifest = $this->get_manifest();
		switch ( $type ) {
			case 'css':
				$files = $manifest->{'index.html'}->css;
				break;
			case 'js':
				$files = array( $manifest->{'index.html'}->file );
				break;
			default:
				$files = array();
		}

		return array_map(
			function( $file ) {
				return $this->build_uri . \DIRECTORY_SEPARATOR . 'js' . \DIRECTORY_SEPARATOR .  $file;
			},
			$files
		);
	}

	/**
	 * Gets the main JS file uri from the manifest.
	 *
	 * @return string
	 */
	public function get_js_uri(): string {
		return $this->get_asset_uri( 'js' )[0];
	}

	/**
	 * Gets the css files uri from the manifest.
	 *
	 * @return string[]
	 */
	public function get_css_uris(): array {
		return $this->get_asset_uri( 'css' );
	}

}
