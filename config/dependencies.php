<?php

declare(strict_types=1);

/**
 * All custom rules for the DI Container.
 * See docs at https://app.gitbook.com/@glynn-quelch/s/pinkcrab/application/dependency-injection
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

use PC_Woo_Stock_Man\Pixie\Connection;
use PinkCrab\Stock_Management\SPA\Spa_Assets;
use PC_Woo_Stock_Man\Respect\Validation\Factory;
use PC_Woo_Stock_Man\Awurth\SlimValidation\Validator;
use PC_Woo_Stock_Man\Pixie\QueryBuilder\QueryBuilderHandler;
use PC_Woo_Stock_Man\Gin0115\ViteManifestParser\ManifestParser;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\View\Component\Component_Compiler;

return array(
	'*'                        => array(
		'substitutions' => array(
			// Validator::class => ( function() {
			// 	$factory = new class() extends Factory{
			// 		protected $rulePrefixes = array(
			// 			'PC_Woo_Stock_Man\\Respect\\Validation\\Rules\\',
			// 		);
			// 	};
			// 	PC_Woo_Stock_Man\Respect\Validation\Validator::setFactory( $factory );
			// 	return new Validator( true, array() );
			// } )(),
		),
	),
	// Component_Compiler::class  => array( 'constructParams' => array( 'views.components' ) ),
	// ManifestParser::class      => array(
	// 	'constructParams' => array(
	// 		plugin_dir_url( dirname( __FILE__, 1 ) ) . 'build/js/',
	// 		dirname( __FILE__, 2 ) . '/build/js/manifest.json',
	// 	),
	// ),
	QueryBuilderHandler::class => array(
		'constructParams' => array(
			new Connection(
				$GLOBALS['wpdb'],
				array(
					Connection::USE_WPDB_PREFIX => true,
					Connection::SHOW_ERRORS     => false,
				),
			),
		),
	),
);
