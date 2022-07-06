<?php

namespace pc_stock_man_v1;

use pc_stock_man_v1\Dice\Dice;
use pc_stock_man_v1\PinkCrab\HTTP\HTTP;
use pc_stock_man_v1\PinkCrab\Registerables\Ajax;
use pc_stock_man_v1\PinkCrab\Perique\Application\App;
use pc_stock_man_v1\PinkCrab\Perique\Services\Dice\WP_Dice;
use pc_stock_man_v1\PinkCrab\Perique\Application\App_Factory;
use pc_stock_man_v1\PinkCrab\Perique\Interfaces\DI_Container;
use pc_stock_man_v1\PinkCrab\Perique\Services\ServiceContainer\Container;
/**
 * PHPUnit bootstrap file
 */
// Composer autoloader must be loaded before WP_PHPUNIT__DIR will be available
require_once \dirname(__DIR__) . '/vendor/autoload.php';
// Give access to tests_add_filter() function.
require_once \getenv('WP_PHPUNIT__DIR') . '/includes/functions.php';
$wp_install_path = \dirname(__FILE__, 2) . '/wordpress';
\define('TEST_WP_ROOT', $wp_install_path);
\pc_stock_man_v1\tests_add_filter('muplugins_loaded', function () {
});
// Start up the WP testing environment.
require \getenv('WP_PHPUNIT__DIR') . '/includes/bootstrap.php';
\define('FIXTURES', __DIR__ . '/Fixtures');
