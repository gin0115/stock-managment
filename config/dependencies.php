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

use PinkCrab\Stock_Management\SPA\Spa_Assets;

return array(
	'*'               => array(
		'substitutions' => array(),
	),
	Spa_Assets::class => array(
		'constructParams' => array(
			dirname( __FILE__, 2 ) . '/build/js/manifest.json',
			plugin_dir_url( dirname( __FILE__, 1 ) ) . 'build',
		),
	),
);
