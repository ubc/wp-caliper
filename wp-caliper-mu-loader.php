<?php
/**
 * This file will allow this plugin to work in mu-plugins folder.
 * Steps:
 * 1. copy the plugin "wp-caliper" folder into the "wp-content/mu-plugins/" folder
 * 2. copy this file into the "wp-content/mu-plugins/" folder
 */

define( 'WP_CALIPER_MU_MODE', true );
if ( defined( 'WPMU_PLUGIN_DIR' ) ) {
	define( 'WP_CALIPER_PLUGIN_DIR', WPMU_PLUGIN_DIR . '/wp-caliper/' );
} else {
	define( 'WP_CALIPER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) . 'wp-caliper/' );
}
require_once( WP_CALIPER_PLUGIN_DIR . '/wp-caliper.php' );
