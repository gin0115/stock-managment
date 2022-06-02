<?php

namespace PC_Woo_Stock_Man;

use PC_Woo_Stock_Man\Dice\Dice;
use PC_Woo_Stock_Man\PinkCrab\HTTP\HTTP;
use PC_Woo_Stock_Man\PinkCrab\Registerables\Ajax;
use PC_Woo_Stock_Man\PinkCrab\Perique\Application\App;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\Dice\WP_Dice;
use PC_Woo_Stock_Man\PinkCrab\Perique\Application\App_Factory;
use PC_Woo_Stock_Man\PinkCrab\Perique\Interfaces\DI_Container;
use PC_Woo_Stock_Man\PinkCrab\Perique\Services\ServiceContainer\Container;
/**
 * PHPUnit bootstrap file
 */
// Composer autoloader must be loaded before WP_PHPUNIT__DIR will be available
require_once \dirname(__DIR__) . '/vendor/autoload.php';
// Give access to tests_add_filter() function.
require_once \getenv('WP_PHPUNIT__DIR') . '/includes/functions.php';
$wp_install_path = \dirname(__FILE__, 2) . '/wordpress';
\define('TEST_WP_ROOT', $wp_install_path);
\PC_Woo_Stock_Man\tests_add_filter('muplugins_loaded', function () {
});
// Start up the WP testing environment.
require \getenv('WP_PHPUNIT__DIR') . '/includes/bootstrap.php';
\define('FIXTURES', __DIR__ . '/Fixtures');
