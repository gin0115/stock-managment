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

return array(
	// Sets the base path for views.
	// If you are using a different views path, please update in PHP_Engine args
	// Remove this if not planning to use the View or replace if using BladeOne
	'*' => array(
		'substitutions' => array(
		),
	),
);
