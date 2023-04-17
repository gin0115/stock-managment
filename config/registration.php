<?php


declare(strict_types=1);

/**
 * List of classes passed through the registration service.
 * See docs at https://app.gitbook.com/@glynn-quelch/s/pinkcrab/application/registration
 *
 * @package PinkCrab\Stock_Management
 * @author Glynn Quelch glynn.quelch@gmail.com
 * @since 0.1.0
 */

use PinkCrab\Stock_Management\Blade_Config;
use PinkCrab\Stock_Management\Foo\Foo_Page;
use PinkCrab\Stock_Management\Location\Location_Taxonomy;
use PinkCrab\Stock_Management\Rest\Location\Location_Controller;
use PinkCrab\Stock_Management\Rest\Settings\Settings_Controller;
use PinkCrab\Stock_Management\WP_Admin\Page\Stock_Location_Page;
use PinkCrab\Stock_Management\WP_Admin\GUI\Route\Locations_Route;
use PinkCrab\Stock_Management\WP_Admin\GUI\Route\Locations_Site_Route;

return array(

	// Blade config
	Blade_Config::class,

	// Location
	Location_Taxonomy::class,
	// Stock_Location_Page::class,

	// Rest
	Settings_Controller::class,
	Location_Controller::class,

	// Admin GUI Routes
	// Locations_Route::class,
	// Locations_Site_Route::class,

	Foo_Page::class,
);
