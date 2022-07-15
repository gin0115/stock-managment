<?php

/**
 * Unit tests for the Plugin Settings Service
 *
 * @package PinkCrab\Stock_Management\Tests
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */
namespace PinkCrab\Stock_Management\Tests\Unit\Plugin\Settings;

use PinkCrab\Stock_Management\I18n\Translations;
use PinkCrab\Stock_Management\Plugin\Settings\Settings;
use PC_Woo_Stock_Man\PinkCrab\Perique\Application\App_Config;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;
use PinkCrab\Stock_Management\WP_Repository\Options_Repository;

class Test_Plugin_Settings extends \WP_UnitTestCase {

	/** @testdox It should be possible to access the Perique App_Config object from the setting service. */
	public function test_get_app_config() {
		$app_config      = new App_Config();
		$plugin_settings = new Plugin_Settings(
			$this->createMock( Options_Repository::class ),
			$app_config,
			$this->createMock( Translations::class ),
		);
		$this->assertTrue( $plugin_settings->app_config() instanceof App_Config );
		$this->assertSame( $app_config, $plugin_settings->app_config() );
	}

	/** @testdox It should be possible to access the Translation service from the Plugin Settings service. */
	public function test_get_translations() {
		$translations    = new Translations();
		$plugin_settings = new Plugin_Settings(
			$this->createMock( Options_Repository::class ),
			new App_Config(),
			$translations,
		);
		$this->assertTrue( $plugin_settings->translations() instanceof Translations );
		$this->assertSame( $translations, $plugin_settings->translations() );
	}

	/** @testdox It should be possible to access various values from App_Config but as alias from the Plugin_Settings service. */
	public function test_get_app_config_values() {
		$app_config = new App_Config(
			array(
				'taxonomies' => array( 'location' => 'foo' ),
				'namespaces' => array( 'rest' => 'pinkcrab/stockman/v1' ),
				'additional' => array(
					'admin_slugs' => (object) array(
						'location' => 'pc_stockman_location',
					),
				),
			)
		);

		$plugin_settings = new Plugin_Settings(
			$this->createMock( Options_Repository::class ),
			$app_config,
			$this->createMock( Translations::class ),
		);

		$this->assertSame( 'foo', $plugin_settings->location_taxonomy() );
		$this->assertSame( 'pinkcrab/stockman/v1', $plugin_settings->rest_namespace() );
		$this->assertSame( 'pc_stockman_location', $plugin_settings->location_menu_page() );
		$this->assertSame( '0.1.0', $plugin_settings->version() );
	}

	/** @testdox It should be possible to get, set and delete custom settings using the plugin settings service. */
	public function test_custom_settings() {

		$custom_settings    = new Settings();
		$options_repository = $this->createMock( Options_Repository::class );
		$options_repository->method( 'get' )
			->willReturn( $custom_settings );

		// Updating the settings.
		$updated_custom_settings = new Settings();
		$has_updated             = false;
		$options_repository->method( 'set_as_not_autoloaded' )
			->willReturnCallback(
				function( $key, $settings ) use ( $updated_custom_settings, &$has_updated ): bool {
					$this->assertEquals( $updated_custom_settings, $settings );
                    $has_updated = true;
					return true;
				}
			);

		// Clearing the settings.
		$has_deleted             = false;
        $options_repository->method( 'clear' )
            ->willReturnCallback(
                function( $key ) use ( &$has_deleted ): bool {
                    $has_deleted = true;
                    return true;
                }
            );
        
        $app_config      = new App_Config();
		$plugin_settings = new Plugin_Settings(
			$options_repository,
			$app_config,
			$this->createMock( Translations::class ),
		);

		$this->assertSame( $custom_settings, $plugin_settings->get_custom_settings() );
		
        $plugin_settings->set_custom_settings($updated_custom_settings);
        $this->assertTrue( $has_updated );

        $plugin_settings->delete_custom_settings();
        $this->assertTrue( $has_deleted );
	}
}
