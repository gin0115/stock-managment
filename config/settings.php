<?php

declare(strict_types=1);

/**
 * Holds all custom app config values.
 * See docs at https://app.gitbook.com/@glynn-quelch/s/pinkcrab/application/app_config
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

return array(
	'post_types' => array(),
	'taxonomies' => array(
		'location' => 'pc_stockman_location',
	),
	'meta'       => array(
		'post' => array(),
		'user' => array(),
		'term' => array(),
	),
	'plugin'     => array( 'version' => '0.1.0' ),
	'namespaces' => array(
		'rest'  => 'pinkcrab/stock_management/v1/rest',
		'cache' => 'pinkcrab_stock_management',
	),
	'additional' => array(
		'admin_slugs' => (object) array(
			'location' => 'pc_stockman_location',
		),
	),
);
