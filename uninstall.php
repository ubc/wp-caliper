<?php
/**
 * If uninstall not called from WordPress, then exit.
 *
 * @package wp-caliper
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
