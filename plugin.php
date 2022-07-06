<?php

/**
 * @wordpress-plugin
 * Plugin Name:     PinkCrab Stock Management
 * Plugin URI:      https://github.com/gin0115/stock-management
 * Description:     Plugin for making stock management much easier
 * Version:         0.1.0
 * Author:          Glynn Quelch
 * Author URI:      https://github.com/gin0115
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     pc_stock_man
 */

use pc_stock_man_v1\PinkCrab\Perique\Services\View\View;
use pc_stock_man_v1\PinkCrab\BladeOne\BladeOne_Bootstrap;
use pc_stock_man_v1\PinkCrab\Perique\Application\App_Factory;
use pc_stock_man_v1\PinkCrab\Perique_Admin_Menu\Registration_Middleware\Page_Middleware;
use pc_stock_man_v1\PinkCrab\Registerables\Registration_Middleware\Registerable_Middleware;

require_once __DIR__ . '/function_pollyfills.php';
require_once __DIR__ . '/build/vendor/autoload.php';

BladeOne_Bootstrap::use( __DIR__ . '/views', dirname( __DIR__, 2 ) . '/view-cache' );

$app = ( new App_Factory( __DIR__ ) )->with_wp_dice( true )
	->di_rules( require __DIR__ . '/config/dependencies.php' )
	->app_config( require __DIR__ . '/config/settings.php' )
	->registration_classes( require __DIR__ . '/config/registration.php' )
	->construct_registration_middleware( Registerable_Middleware::class )
	->construct_registration_middleware( Page_Middleware::class )
	->boot();

// dd($app->make(View::class)->engine()->get_blade()); 
