<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Sample_Plugin
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	echo "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?";
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/wp-caliper.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );


function generate_unique( $string, $user_id, $user_data ) {
	return $user_id;
}
tests_add_filter( 'wp_caliper_actor_identifier', 'generate_unique', 10, 3 );

function actor_homepage( $string ) {
	return 'http://test.homepage.com';
}
tests_add_filter( 'wp_caliper_actor_homepage', 'actor_homepage', 10, 1 );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
