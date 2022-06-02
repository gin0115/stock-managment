<?php

namespace PC_Woo_Stock_Man;

use PC_Woo_Stock_Man\PinkCrab\Core\Application\App;
use PC_Woo_Stock_Man\PinkCrab\Core\Services\Dice\Dice;
use PC_Woo_Stock_Man\PinkCrab\Core\Services\Dice\WP_Dice;
use PC_Woo_Stock_Man\PinkCrab\Core\Application\App_Config;
use PC_Woo_Stock_Man\PinkCrab\Core\Services\Registration\Loader;
use PC_Woo_Stock_Man\PinkCrab\Core\Services\ServiceContainer\Container;
use PC_Woo_Stock_Man\PinkCrab\Core\Services\Registration\Register_Loader;
/**
 * PHPUnit bootstrap file
 */
// Composer autoloader must be loaded before WP_PHPUNIT__DIR will be available
require_once \dirname(__DIR__) . '/vendor/autoload.php';
// Give access to tests_add_filter() function.
require_once \getenv('WP_PHPUNIT__DIR') . '/includes/functions.php';
\PC_Woo_Stock_Man\tests_add_filter('muplugins_loaded', function () {
});
// Start up the WP testing environment.
require \getenv('WP_PHPUNIT__DIR') . '/includes/bootstrap.php';
