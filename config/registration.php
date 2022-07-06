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

use PinkCrab\Stock_Management\Location\Location_Taxonomy;
use PinkCrab\Stock_Management\WP_Admin\Page\Stock_Location_Page;

return array(

	// Location
	Location_Taxonomy::class,
	Stock_Location_Page::class,
);
