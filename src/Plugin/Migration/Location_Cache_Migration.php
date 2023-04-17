<?php

declare(strict_types=1);

/**
 * Location Cache Table Migration
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

namespace PinkCrab\Stock_Management\Plugin\Migration;

use PC_Woo_Stock_Man\PinkCrab\Table_Builder\Schema;
use PC_Woo_Stock_Man\PinkCrab\Perique\Migration\Migration;
use PinkCrab\Stock_Management\Plugin\Settings\Plugin_Settings;

class Location_Cache_Migration extends Migration {

	private Plugin_Settings $plugin_settings;

	public function __construct( Plugin_Settings $plugin_settings ) {
		$this->plugin_settings = $plugin_settings;
		parent::__construct();
	}

	/** Gets the table name from the App_Config (Perique Config) */
	protected function table_name(): string {
		return $this->plugin_settings->app_config()->db_tables( 'location_cache' );
	}

	/**Defines the schema for the migration. */
	public function schema( Schema $schema_config ): void {
		$schema_config->column( 'id' )->unsigned_int( 11 )->auto_increment();
		$schema_config->index( 'id' )->primary();
		$schema_config->column( 'data' )->json();

	}

	/**
	 * Defines the data to be seeded. */
	public function seed( array $seeds ): array {
		return array();
	}

	/** Drop table on uninstall. (Defaults to false). */
	public function drop_on_uninstall(): bool {
		return true;
	}
}
