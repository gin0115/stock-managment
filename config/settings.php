<?php

declare(strict_types=1);

/**
 * Holds all custom app config values.
 * See docs at https://app.gitbook.com/@glynn-quelch/s/pinkcrab/application/app_config
 *
 * @package PinkCrab\Framework
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

return array(
	'taxonomies' => array( 'location' => 'stock_location' ),
	'meta'       => array(
		'post' => array(),
		'user' => array(),
		'term' => array(
			'type'    => 'location_type',
			'ref'     => 'location_ref',
			'barcode' => 'location_barcode',
		),
	),
	'plugin'     => array( 'version' => '0.1.0' ),
	'namespaces' => array(
		'rest'  => 'pinkcrab/stockman/v1',
		'cache' => 'pinkcrab_stockman',
	),
	'additional' => array(
		'admin_slugs'    => (object) array(
			'location' => 'pc_stockman_location',
		),
	),
);
