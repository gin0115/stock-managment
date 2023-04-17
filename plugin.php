<?php

/**
 * @wordpress-plugin
 * Plugin Name:     Pc_woo_stock_man
 * Plugin URI:      https://github.com/gin0115/stock-managment
 * Description:     A plugin for making stock management with WooCommerce much easier from a warehousing persoective
 * Version:         0.1.0
 * Author:          Glynn Quelch
 * Author URI:      https://github.com/gin0115
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     pc_stock_man
 */
use PinkCrab\Perique_Page_Router\Router\Router;
use PinkCrab\Stock_Management\Form\Form_Service;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Ajax_Bootstrap;
use PC_Woo_Stock_Man\PinkCrab\Queue\Queue_Bootstrap;
use PinkCrab\Stock_Management\Form\Field\Input\Text;
use PinkCrab\Stock_Management\Form\Field\Input_Text;
use PinkCrab\Stock_Management\Form\Field\Input\Number;
use PC_Woo_Stock_Man\PinkCrab\BladeOne\BladeOne_Bootstrap;
use PC_Woo_Stock_Man\PinkCrab\Perique\Migration\Migrations;
use PC_Woo_Stock_Man\PinkCrab\Perique\Application\App_Factory;
use PinkCrab\Stock_Management\Plugin\Migration\Location_Migration;
use PC_Woo_Stock_Man\PinkCrab\Plugin_Lifecycle\Plugin_State_Controller;
use PinkCrab\Stock_Management\Plugin\Migration\Location_Cache_Migration;
use PC_Woo_Stock_Man\PinkCrab\Ajax\Registration_Middleware\Ajax_Middleware;
use PC_Woo_Stock_Man\PinkCrab\Queue\Registration_Middleware\Queue_Middleware;
use PC_Woo_Stock_Man\PinkCrab\Route\Registration_Middleware\Route_Middleware;
use PC_Woo_Stock_Man\PinkCrab\Perique_Admin_Menu\Registration_Middleware\Page_Middleware;
use PC_Woo_Stock_Man\PinkCrab\Queue\Queue_Driver\Action_Scheduler\Action_Scheduler_Driver;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Registration_Middleware\Registerable_Middleware;
use PinkCrab\Perique_Page_Router\Registration_Middleware\Page_Router_Registration_Middleware;

require_once __DIR__ . '/function_pollyfills.php';
require_once __DIR__ . '/build/php/vendor/autoload.php';
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap all required modules (sets up DI Rules)
Queue_Bootstrap::init( Action_Scheduler_Driver::get_instance() );
Ajax_Bootstrap::use();
BladeOne_Bootstrap::use( __DIR__ . DIRECTORY_SEPARATOR );

// Boot the application
$app = ( new App_Factory( __DIR__ ) )->with_wp_dice( true )
	->di_rules( require __DIR__ . '/config/dependencies.php' )
	->app_config( require __DIR__ . '/config/settings.php' )
	->registration_classes( require __DIR__ . '/config/registration.php' )
	->construct_registration_middleware( Page_Router_Registration_Middleware::class )
	->construct_registration_middleware( Page_Middleware::class )
	->construct_registration_middleware( Ajax_Middleware::class )
	->construct_registration_middleware( Route_Middleware::class )
	->construct_registration_middleware( Registerable_Middleware::class )
	->construct_registration_middleware( Queue_Middleware::class )
	->boot();
// dump($app);
// dump($app::view()->engine()->get_blade());


// Register the plugin lifecycle events.
$plugin_state_controller = new Plugin_State_Controller( $app, __FILE__ );

// Register all migrations
$migrations = new Migrations( $plugin_state_controller, 'pc_stock_management' );

// Add the tables.
$migrations->add_migration( Location_Migration::class );
$migrations->add_migration( Location_Cache_Migration::class );

// Finalise all migrations and actions.
$migrations->done();

$plugin_state_controller->finalise();

// Debug helpers, remove this in production.
add_filter(
	'wp_php_error_args',
	function( $message, $error ) {
		echo "<strong>Error type</strong> : {$error['type']}<hr>";
		echo "<strong>Message </strong> : <pre style='color: #333; font-face:monospace; font-size:8pt;'>{$error['message']}</pre><hr>";
		echo "<strong>File </strong> : {$error['file']}<hr>";
		echo "<strong>Line </strong> : {$error['line']}<hr>";
		dd( $error, $message );
	},
	2,
	10
);

add_action(
	'init',
	function() use ( $app ) {
		return;
		/** @var Form_Service */
		$builder = $app::make( Form_Service::class );
		dd(
			$builder
				->create( 'test' )
				->enctype( 'multipart/form-data' )
				->target( '_blank' )
				->autocomplete( 'on' )
				->add_field(
					'foo',
					Text::class,
					fn( Text $f): Text =>
						$f->sanitizer( 'esc_html' )
							->autocomplete( 'on' )
							->attribute( 'data-foo', 'bar' )
							->value( 'bar' )
							->datalist_item( 'foo', 'bar' )
				)
				->add_field(
					'bar',
					Number::class,
					fn( Number $f): Number =>
						$f->sanitizer( 'esc_html' )
							->autocomplete( 'on' )
							->attribute( 'data-foo', 'bar' )
							->value( 2 )
				)
				->add_value( 'foo', '<p>test value</p>' )
		);
	}
);
