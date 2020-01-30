<?php
/**
 * Plugin Name: WP Caliper
 * Plugin URI: https://github.com/ubc/wp-caliper
 * Version: 1.1.0
 * Description: This plugin generates and emits Caliper events to the specified LRS
 * Tags: Caliper
 * Author: CTLT, Andrew Gardener
 * Author URI: https://github.com/ubc
 * License: GPL-3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package wp-caliper
 */

namespace WPCaliperPlugin;

use WPCaliperPlugin\caliper\CaliperSensor;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
if ( ! defined( 'WP_CALIPER_PLUGIN_DIR' ) ) {
	define( 'WP_CALIPER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
require_once( WP_CALIPER_PLUGIN_DIR . 'wp-caliper-config.php' );
require_once( WP_CALIPER_PLUGIN_DIR . 'vendor/autoload.php' );
require_once( WP_CALIPER_PLUGIN_DIR . 'wp-caliper-queue.php' );

$plugin_data = get_file_data( __FILE__, array( 'Version' => 'Version' ), false );
define( 'WP_CALIPER_PLUGIN_VERSION', $plugin_data['Version'] );


/**
 * WP_Caliper plugin main
 */
class WP_Caliper {
	/**
	 * Stores if network enabled
	 *
	 * @var $network_enabled
	 */
	private static $network_enabled;
	/**
	 * Stores network options
	 *
	 * @var $network_options
	 */
	private static $network_options;
	/**
	 * Stores local options
	 *
	 * @var $local_options
	 */
	private static $local_options;
	/**
	 * Stores list of dependencies
	 *
	 * @var $dependencies
	 */
	public static $dependencies = array(
		'BadgeOS'                          => 'http://wordpress.org/plugins/badgeos/',
		'BadgeOS_Open_Badges_Issuer_AddOn' => 'https://github.com/ubc/open-badges-issuer-addon',
	);

	/**
	 * Initialization function
	 *
	 * @return void
	 */
	public static function init() {
		// check that php version is >= 5.6 .
		if ( ! self::check_php_version() ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			add_action( 'admin_notices', array( 'WPCaliperPlugin\\WP_Caliper', 'wp_php_disable_notice' ) );
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			return;
		}

		if ( is_multisite() && ! function_exists( 'is_plugin_active_for_network' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}
		self::$network_enabled = ( is_multisite() && is_plugin_active_for_network( 'wp-caliper/wp-caliper.php' ) ) || defined( 'WP_CALIPER_MU_MODE' );

		// setup options.
		self::setup_caliper_sensor();

		// check if there are issues.
		if ( self::$network_enabled ) {
			self::check_network_options();
		} else {
			self::check_local_options();
		}

		// add admin menus.
		if ( is_admin() || is_network_admin() ) {
			require_once( plugin_dir_path( __FILE__ ) . 'wp-caliper-admin.php' );
			new WP_Caliper_Admin();
		}

		if ( CaliperSensor::caliper_enabled() ) {
			require_once( plugin_dir_path( __FILE__ ) . 'wp-caliper-event-hooks.php' );
		}

		// needs to check if queue is empty or not and display admin notices as appropriate.
		add_action( 'admin_notices', array( 'WPCaliperPlugin\\WP_Caliper', 'caliper_queue_is_not_emtpy_notice' ) );
		add_action( 'network_admin_notices', array( 'WPCaliperPlugin\\WP_Caliper', 'caliper_queue_is_not_emtpy_notice' ) );
	}

	/**
	 * Creates the backup queue table
	 *
	 * @return void
	 */
	public static function wp_caliper_on_activate() {
		global $wpdb;

		$current_version = get_site_option( 'wp_caliper_db_installed' );
		$plugin_version  = esc_html( WP_CALIPER_PLUGIN_VERSION );

		// Version 1.0.0 adds queue table.
		if ( empty( $current_version ) || version_compare( '1.0.0', $current_version, '>' ) ) {

			// use base_prefix so it will be on global regardless of mu or single site.
			$table_name = WP_Caliper_Queue_Job::get_table_name();

			if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) !== $table_name ) {
				$charset_collate = '';
				if ( ! empty( $wpdb->charset ) ) {
					$charset_collate .= "DEFAULT CHARACTER SET {$wpdb->charset}";
				}
				if ( ! empty( $wpdb->collate ) ) {
					$charset_collate .= " COLLATE {$wpdb->collate}";
				}
				$sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
					id bigint NOT null AUTO_INCREMENT,
					tries tinyint UNSIGNED NOT null DEFAULT '1',
					last_try_time datetime,
					`event` text NOT null,
					blog_id bigint,
					created timestamp DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY ( id )
				) {$charset_collate};";
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
			}
		}

		// finish by updating wp_caliper_db_installed if needed.
		if ( empty( $current_version ) || version_compare( $plugin_version, $current_version, '>' ) ) {
			update_site_option( 'wp_caliper_db_installed', $plugin_version );
		}
	}

	/**
	 * Checks that the php installed on the server meets the minimum required by this plugin
	 * ( currently caliper-php recommends PHP5.6 )
	 *
	 * @return bool
	 */
	private static function check_php_version() {
		return version_compare( phpversion(), WP_CALIPER_MINIMUM_PHP_VERSION, '>=' );
	}

	/**
	 * Setup the Caliper sensor with rather local site options or network options
	 * ( tries site options first )
	 *
	 * @param string|integer $blog_id blog id.
	 * @return void
	 */
	private static function setup_caliper_sensor( $blog_id = null ) {
		// load network settings if network enabled.
		if ( self::$network_enabled ) {
			self::$network_options = get_site_option( 'wp_caliper_network_settings' );
		} else {
			self::$network_options = null;
		}

		// load local settings if network allows.
		if ( empty( self::$network_options ) || 'Yes' !== self::$network_options['wp_caliper_disable_local_site_settings'] ) {
			if ( function_exists( 'get_blog_option' ) ) {
				self::$local_options = get_blog_option( $blog_id, 'wp_caliper_settings' );
			} else {
				self::$local_options = get_option( 'wp_caliper_settings' );
			}
		} else {
			self::$local_options = null;
		}

		// if disabled at site or network level, do not emit any events.
		if ( ( ! empty( self::$local_options ) && 'Yes' === self::$local_options['wp_caliper_disabled'] ) ||
			( ! empty( self::$network_options ) && 'Yes' === self::$network_options['wp_caliper_disabled'] ) ) {
			return;
		}

		if ( ! empty( self::$local_options ) &&
			! empty( self::$local_options['wp_caliper_host'] ) &&
			! empty( self::$local_options['wp_caliper_api_key'] ) ) {
			CaliperSensor::set_options( self::$local_options['wp_caliper_host'], self::$local_options['wp_caliper_api_key'] );
		} elseif ( self::$network_enabled &&
				! empty( self::$network_options ) &&
				! empty( self::$network_options['wp_caliper_host'] ) &&
				! empty( self::$network_options['wp_caliper_api_key'] ) ) {
			CaliperSensor::set_options( self::$network_options['wp_caliper_host'], self::$network_options['wp_caliper_api_key'] );
		}
	}

	/**
	 * Check that the network options are properly configured
	 *
	 * @return void
	 */
	private static function check_network_options() {
		if ( empty( self::$network_options ) || empty( self::$network_options['wp_caliper_api_key'] ) || empty( self::$network_options['wp_caliper_host'] ) ) {
			add_action( 'admin_notices', array( 'WPCaliperPlugin\\WP_Caliper', 'wp_config_unset_network_notice' ) );
			error_log( '[wp-caliper] Please tell Network Administrator to set the default host and API key of the Caliper LRS ( WP Caliper Plugin )' );
		}
		if ( ! empty( self::$network_options ) && 'Yes' === self::$network_options['wp_caliper_disabled'] ) {
			add_action( 'admin_notices', array( 'WPCaliperPlugin\\WP_Caliper', 'wp_disabled_network_caliper_events_notice' ) );
			error_log( '[wp-caliper] The Network Administrator chose to disable Caliper events to be sent to the Network level LRS.' );
		}
		if ( ! empty( self::$local_options ) && 'Yes' === self::$local_options['wp_caliper_disabled'] ) {
			add_action( 'admin_notices', array( 'WPCaliperPlugin\\WP_Caliper', 'wp_disabled_local_caliper_events_notice' ) );
			error_log( '[wp-caliper] The Administrator chose to disable Caliper events to be sent to the Site level LRS.' );
		}
	}

	/**
	 * Check that the options are properly configured
	 *
	 * @return void
	 */
	private static function check_local_options() {
		if ( ! is_multisite() && ( empty( self::$local_options ) || empty( self::$local_options['wp_caliper_api_key'] ) || empty( self::$local_options['wp_caliper_host'] ) ) ) {
			add_action( 'admin_notices', array( 'WPCaliperPlugin\\WP_Caliper', 'wp_config_unset_local_notice' ) );
			error_log( '[wp-caliper] Please tell the Site Administrator to set the host and API key of the Caliper LRS ( WP Caliper Plugin )' );
		}
		if ( ! empty( self::$local_options ) && 'Yes' === self::$local_options['wp_caliper_disabled'] ) {
			add_action( 'admin_notices', array( 'WPCaliperPlugin\\WP_Caliper', 'wp_disabled_local_caliper_events_notice' ) );
			error_log( '[wp-caliper] The Administrator chose to disable Caliper events to be sent to the Site level LRS.' );
		}
	}

	/**
	 * Adds failed events to queue ( triggered on failure )
	 *
	 * @param string $event_json the event JSON.
	 * @param int    $blog_id the blog id source of the event ( for determining which Caliper settings local/network ).
	 * @return Boolean true if it worked, false otherwise
	 */
	public static function wp_caliper_add_queue( $event_json, $blog_id = null ) {
		$queue_job          = new WP_Caliper_Queue_Job();
		$queue_job->event   = $event_json;
		$queue_job->blog_id = $blog_id;
		return (bool) $queue_job->save_new_row();
	}

	/**
	 * Pulls from the queue and tries to resend Caliper events
	 *
	 * NOTES:
	 * - it goes through the entire queue
	 * - checks if past max tries
	 * - tries sending, if fails, adds back to queue
	 *
	 * @return boolean
	 */
	public static function wp_caliper_run_the_queue() {
		$count = self::caliper_queue_size();
		if ( $count > 0 ) {
			$current_index = 0; // counter.

			while ( $current_index < $count ) {
				$current_index++;

				$queue_job = WP_Caliper_Queue_Job::get_row();

				// sanity check that queue_job is NOT empty.
				if ( empty( $queue_job ) ) {
					error_log( '[wp-caliper] The queue is empty but is not supposed to be.' );
					return false;
				}

				// if past max tries, then throw error message into log.
				if ( $queue_job->tries > WP_CALIPER_MAX_SENDING_TRIES ) {
					error_log( '[wp-caliper] Max number of tries exceeded for the following Caliper event: ' . print_r( $queue_job->event, true ) );
					continue;
				}

				/*
				 * Checking retry time is not needed if we're basing it on a retry button
				 * $last_try_time = intval( strtotime( $queue_job->last_try_time ) );
				 * $next_retry_time = $last_try_time + pow( 2, intval( $queue_job->tries ) );
				 * if ( time() < $next_retry_time ) {
				 *     $queue_job->save_new_row();
				 *     continue;
				 * }
				 */

				// Setup the Caliper configuration.
				self::setup_caliper_sensor( $queue_job->blog_id );

				// try remitting the event!
				$success = CaliperSensor::_send_event( $queue_job->event );
				if ( ! $success ) {
					$queue_job->tried_sending_again();
					$queue_job->save_new_row();
				}
			}
		}
		return true;
	}

	/**
	 * Checks count of global event queue
	 *
	 * @return int size of caliper event queue
	 */
	public static function caliper_queue_size() {
		global $wpdb;
		$table_name = WP_Caliper_Queue_Job::get_table_name();
		return $wpdb->get_var( "SELECT COUNT( * ) FROM {$table_name}" );
	}

	/**
	 * Puts up a error notice when the queue is NOT empty. ONLY super admins
	 *
	 * @return void
	 */
	public static function caliper_queue_is_not_emtpy_notice() {
		if ( is_super_admin() ) {
			$count = self::caliper_queue_size();
			if ( $count > 0 ) {
				$message = sprintf( esc_html__( 'The WP Caliper Queue is not empty. Current number of events: %d', 'wp_caliper' ), $count );
				echo '<div class="error notice is-dismissible"><p>' . ( $message ) . '</p></div>';
			}
		}
	}

	/**
	 * Displays message saying installation doesn't meet minimum PHP requirement
	 *
	 * @return void
	 */
	public static function wp_php_disable_notice() {
		echo "<div class='error'><strong>" . esc_html__( 'WP Caliper Plugin requires PHP ' . WP_CALIPER_MINIMUM_PHP_VERSION . ' or higher.', 'wp_caliper' ) . '</strong></div>';
	}

	/**
	 * Displays message saying Caliper events have been disabled for the network
	 *
	 * @return void
	 */
	public static function wp_disabled_network_caliper_events_notice() {
		echo "<div class='update-nag'><p>" . esc_html__( 'The Network Administrator chose to disable Caliper events to be sent to the Network level LRS.', 'wp_caliper' ) . '</p></div>';
	}

	/**
	 * Displays message saying Caliper events have been disabled for the local site
	 *
	 * @return void
	 */
	public static function wp_disabled_local_caliper_events_notice() {
		echo "<div class='update-nag'><p>" . esc_html__( 'The Administrator chose to disable Caliper events to be sent to the Site level LRS.', 'wp_caliper' ) . '</p></div>';
	}

	/**
	 * Displays message saying Caliper events have been disabled for the network
	 *
	 * @return void
	 */
	public static function wp_config_unset_network_notice() {
		echo "<div class='error'><p>" . esc_html__( 'Please tell Network Administrator to set the default host and API key of the Caliper LRS ( WP Caliper Plugin )', 'wp_caliper' ) . '</p></div>';
	}

	/**
	 * Displays message saying Caliper events have been disabled for the local site
	 *
	 * @return void
	 */
	public static function wp_config_unset_local_notice() {
		echo "<div class='error'><p>" . esc_html__( 'Please tell the Site Administrator to set the host and API key of the Caliper LRS ( WP Caliper Plugin )', 'wp_caliper' ) . '</p></div>';
	}
}

WP_Caliper::init();

/*
 * setup the global queue table ( will check if already exists when run again )
 */
register_activation_hook( __FILE__, array( 'WPCaliperPlugin\\WP_Caliper', 'wp_caliper_on_activate' ) );

/*
 * this is for special case of plugin working with mu_plugins folder
 * @props https://wordpress.org/support/topic/register_activation_hook-on-multisite
 */
if ( is_multisite() || defined( 'WP_CALIPER_MU_MODE' ) ) {
	// check if in mu_plugins folder.
	// We go up 2 directories because we assume user installed it properly following instructions!
	if ( WPMU_PLUGIN_DIR === dirname( dirname( __FILE__ ) ) ) {
		WP_Caliper::wp_caliper_on_activate();
	}
}
