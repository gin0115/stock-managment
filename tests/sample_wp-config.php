<?php

/* Path to the WordPress codebase you'd like to test. Add a forward slash in the end. */
define( 'ABSPATH', dirname( dirname( __FILE__ ) ) . '/wordpress/' );

/*
 * Path to the theme to test with.
 *
 * The 'default' theme is symlinked from test/phpunit/data/themedir1/default into
 * the themes directory of the WordPress installation defined above.
 */
define( 'WP_DEFAULT_THEME', 'default' );

// Test with multisite enabled.
// Alternatively, use the tests/phpunit/multisite.xml configuration file.
// define( 'WP_TESTS_MULTISITE', true );

// Force known bugs to be run.
// Tests with an associated Trac ticket that is still open are normally skipped.
// define( 'WP_TESTS_FORCE_KNOWN_BUGS', true );

// Test with WordPress debug mode (default).
define( 'WP_DEBUG', true );

// ** MySQL settings ** //

// This configuration file will be used by the copy of WordPress being tested.
// wordpress/wp-config.php will be ignored.

// WARNING WARNING WARNING!
// These tests will DROP ALL TABLES in the database with the prefix named below.
// DO NOT use a production database or one that is shared with something else.

// These GitHub action MYSQL credentials are set in the actions yaml file
// If you wish to change them, ensure you change them in both places
if ( getenv( 'environment_github' ) ) {
	define( 'DB_NAME', 'pc_plugin_bp' );
	define( 'DB_USER', 'root' );
	define( 'DB_PASSWORD', 'crab' );
	define( 'DB_HOST', '0.0.0.0' );
	define( 'DB_CHARSET', 'utf8' );
	define( 'DB_COLLATE', '' );
} else {
	// IF YOU ARE PLANNING TO RUN THESE TESTS LOCALLY, SET THESE TO MATCH YOUR DB.
	define( 'DB_NAME', getenv( 'WP_DB_NAME' ) ?: '##DB_NAME##' );
	define( 'DB_USER', getenv( 'WP_DB_USER' ) ?: '##DB_USER##' );
	define( 'DB_PASSWORD', getenv( 'WP_DB_PASS' ) ?: '##DB_PASSWORD##' );
	define( 'DB_HOST', '##DB_HOST##' );
	define( 'DB_CHARSET', 'utf8' );
	define( 'DB_COLLATE', '' );
}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 */
define( 'AUTH_KEY', 'put your unique phrase here' );
define( 'SECURE_AUTH_KEY', 'put your unique phrase here' );
define( 'LOGGED_IN_KEY', 'put your unique phrase here' );
define( 'NONCE_KEY', 'put your unique phrase here' );
define( 'AUTH_SALT', 'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT', 'put your unique phrase here' );
define( 'NONCE_SALT', 'put your unique phrase here' );

$table_prefix = 'wpphpunittests_';   // Only numbers, letters, and underscores please!

define( 'WP_TESTS_DOMAIN', 'example.org' );
define( 'WP_TESTS_EMAIL', 'admin@example.org' );
define( 'WP_TESTS_TITLE', 'Test Blog' );

define( 'WP_PHP_BINARY', 'php' );

define( 'WPLANG', '' );