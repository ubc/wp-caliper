<?php
/**
 * Section to do settings page for the wp-caliper
 *
 * @package wp-caliper
 */

namespace WPCaliperPlugin;

/**
 * WP_Caliper_Admin Admin settings
 */
class WP_Caliper_Admin {
	/**
	 * Stores if network is enabled or not
	 *
	 * @var $network_enabled
	 */
	private static $network_enabled;
	/**
	 * Stores admin options
	 *
	 * @var $options
	 */
	private static $options;

	/**
	 * Fields that are saved.
	 *
	 * @var $network_fields
	 */
	private $network_fields = array(
		'wp_caliper_disabled'                    => 'No',
		'wp_caliper_host'                        => '',
		'wp_caliper_api_key'                     => '',
		'wp_caliper_disable_local_site_settings' => 'No',
		'wp_caliper_host_whitelist'              => '',
	);
	/**
	 * Fields that are saved.
	 *
	 * @var $local_fields
	 */
	private $local_fields = array(
		'wp_caliper_disabled' => 'No',
		'wp_caliper_host'     => '',
		'wp_caliper_api_key'  => '',
	);

	/**
	 * Constructor
	 */
	public function __construct() {
		if ( is_multisite() && ! function_exists( 'is_plugin_active_for_network' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}
		self::$network_enabled = ( is_multisite() && is_plugin_active_for_network( 'wp-caliper/wp-caliper.php' ) ) || defined( 'WP_CALIPER_MU_MODE' );

		if ( self::$network_enabled ) {
			add_action( 'network_admin_menu', array( $this, 'wp_caliper_add_network_admin_menu' ) );
			add_action( 'admin_init', array( $this, 'wp_caliper_network_settings_init' ) );

			self::setup_network_options();
			// only show local site Caliper options if network allows.
			if ( 'Yes' !== $this->options['wp_caliper_disable_local_site_settings'] ) {
				add_action( 'admin_menu', array( $this, 'wp_caliper_add_local_admin_menu' ) );
				add_action( 'admin_init', array( $this, 'wp_caliper_local_settings_init' ) );
			}
		} else {
			add_action( 'admin_menu', array( $this, 'wp_caliper_add_local_admin_menu' ) );
			add_action( 'admin_init', array( $this, 'wp_caliper_local_settings_init' ) );
		}

		add_action( 'wp_ajax_wp_caliper_check_and_run_queue', array( $this, 'wp_caliper_check_and_run_queue' ) );
		add_action( 'admin_footer', array( $this, 'wp_caliper_add_js' ) );
	}

	/**
	 * Adds network level admin page
	 */
	public function wp_caliper_add_network_admin_menu() {
		// adding new page.
		add_menu_page(
			'WP Caliper Network',
			'WP Caliper Network',
			'manage_network_plugins',
			'wp_caliper',
			array( $this, 'wp_caliper_network_options_page' ),
			'dashicons-format-status'
		);
	}

	/**
	 * Creates structure of network level settings page
	 *
	 * @return void
	 */
	public function wp_caliper_network_options_page() {
		$this->setup_network_options();

		if ( is_network_admin() && ! empty( $_POST ) ) {
			$valid_fields = array_keys( $this->network_fields );
			$save_array   = $this->network_fields;
			foreach ( $_POST['wp_caliper_settings'] as $key => $value ) {
				if ( in_array( $key, $valid_fields ) ) {
					$save_array[ $key ] = $value;
				}
			}

			$this->options = $save_array;
			update_site_option( 'wp_caliper_network_settings', $this->options );
		}
		?>
			<form method='post'>
			<?php
			settings_fields( 'wp_caliper_network' );
			do_settings_sections( 'wp_caliper_network' );
			submit_button();
			?>
			</form>
		<?php
	}


	/**
	 * Loads network settings and sets default if needed
	 *
	 * @return void
	 */
	private function setup_network_options() {
		$this->options = get_site_option( 'wp_caliper_network_settings' );
		if ( false === $this->options ) {
			$this->options = $this->network_fields;
			add_site_option( 'wp_caliper_settings', $this->options );
		}
	}

	/**
	 * Creates structure of local settings page
	 *
	 * @return void
	 */
	public function wp_caliper_add_local_admin_menu() {
		// adding new page.
		add_menu_page(
			'WP Caliper',
			'WP Caliper',
			'manage_options',
			'wp_caliper',
			array( $this, 'wp_caliper_local_options_page' ),
			'dashicons-format-status'
		);
	}

	/**
	 * Creates structure of network level settings page
	 *
	 * @return void
	 */
	public function wp_caliper_local_options_page() {
		$this->setup_local_options();

		if ( is_admin() && ! empty( $_POST ) ) {
			$valid_fields = array_keys( $this->local_fields );
			$save_array   = $this->local_fields;
			foreach ( $_POST['wp_caliper_settings'] as $key => $value ) {
				if ( in_array( $key, $valid_fields ) ) {
					$save_array[ $key ] = $value;
				}
			}

			$this->options = $save_array;
			if ( function_exists( 'update_blog_option' ) ) {
				update_blog_option( null, 'wp_caliper_settings', $this->options );
			} else {
				update_option( 'wp_caliper_settings', $this->options );
			}
		}
		?>
			<form method='post'>
			<?php
			settings_errors( 'wpCaliperHostInvalid' );
			settings_fields( 'wp_caliper_local' );
			do_settings_sections( 'wp_caliper_local' );
			submit_button();
			?>
			</form>
		<?php
	}


	/**
	 * Loads network settings and sets default if needed
	 *
	 * @return void
	 */
	private function setup_local_options() {
		if ( function_exists( 'get_blog_option' ) ) {
			$this->options = get_blog_option( null, 'wp_caliper_settings' );
		} else {
			$this->options = get_option( 'wp_caliper_settings' );
		}

		if ( false === $this->options ) {
			$this->options = $this->local_fields;
			if ( function_exists( 'add_blog_option' ) ) {
				add_blog_option( null, 'wp_caliper_settings', $this->options );
			} else {
				add_option( 'wp_caliper_settings', $this->options );
			}
		}
	}

	/**
	 * Setting up settings page fields
	 *
	 * @return void
	 */
	public function wp_caliper_network_settings_init() {
		add_settings_section(
			'wp_caliper_network_settings_section',
			__( 'WP Caliper Network Settings', 'wp_caliper' ),
			array( $this, 'wp_caliper_section_callback' ),
			'wp_caliper_network'
		);
		add_settings_field(
			'wp_caliper_network_run_queue',
			__( 'Run Caliper Queue', 'wp_caliper' ),
			array( $this, 'wp_caliper_run_queue_render' ),
			'wp_caliper_network',
			'wp_caliper_network_settings_section'
		);
		add_settings_field(
			'wp_caliper_network_disabled',
			__( 'Disable All Caliper Events', 'wp_caliper' ),
			array( $this, 'wp_caliper_disabled_render' ),
			'wp_caliper_network',
			'wp_caliper_network_settings_section'
		);
		add_settings_field(
			'wp_caliper_network_host',
			__( 'Default Host URL', 'wp_caliper' ),
			array( $this, 'wp_caliper_host_render' ),
			'wp_caliper_network',
			'wp_caliper_network_settings_section'
		);
		add_settings_field(
			'wp_caliper_network_api_key',
			__( 'Default API Key', 'wp_caliper' ),
			array( $this, 'wp_caliper_api_key_render' ),
			'wp_caliper_network',
			'wp_caliper_network_settings_section'
		);
		add_settings_field(
			'wp_caliper_network_disable_local_site_settings',
			__( 'Disable Site Level Caliper Settings', 'wp_caliper' ),
			array( $this, 'wp_caliper_disable_local_site_settings_render' ),
			'wp_caliper_network',
			'wp_caliper_network_settings_section'
		);
		add_settings_field(
			'wp_caliper_host_whitelist',
			__( 'Whitelisted LRS domains', 'wp_caliper' ),
			array( $this, 'wp_caliper_host_whitelist_render' ),
			'wp_caliper_network',
			'wp_caliper_network_settings_section'
		);
	}

	/**
	 * Setting up settings page fields
	 *
	 * @return void
	 */
	public function wp_caliper_local_settings_init() {
		register_setting(
			'wp_caliper_local',
			'wp_caliper_local_settings',
			array( $this, 'wp_caliper_sanitize_options' )
		);
		add_settings_section(
			'wp_caliper_local_settings_section',
			__( 'WP Caliper Settings', 'wp_caliper' ),
			array( $this, 'wp_caliper_section_callback' ),
			'wp_caliper_local'
		);
		add_settings_field(
			'wp_caliper_local_run_queue',
			__( 'Run Caliper Queue', 'wp_caliper' ),
			array( $this, 'wp_caliper_run_queue_render' ),
			'wp_caliper_local',
			'wp_caliper_local_settings_section'
		);
		add_settings_field(
			'wp_caliper_local_disabled',
			__( 'Disable Caliper Events', 'wp_caliper' ),
			array( $this, 'wp_caliper_disabled_render' ),
			'wp_caliper_local',
			'wp_caliper_local_settings_section'
		);
		add_settings_field(
			'wp_caliper_local_host',
			__( 'Host URL', 'wp_caliper' ),
			array( $this, 'wp_caliper_host_render' ),
			'wp_caliper_local',
			'wp_caliper_local_settings_section'
		);
		add_settings_field(
			'wp_caliper_local_api_key',
			__( 'API Key', 'wp_caliper' ),
			array( $this, 'wp_caliper_api_key_render' ),
			'wp_caliper_local',
			'wp_caliper_local_settings_section'
		);
	}

	/**
	 * Outputs Button to run the failed event queue
	 *
	 * @return void
	 */
	public function wp_caliper_run_queue_render() {
		$count = WP_Caliper::caliper_queue_size();
		?>
		<input type='button' class='button button-primary' id='wp_caliper_run_queue' value="<?php echo esc_html__( 'Run Queue' ); ?>"><br>
		<div class="help-div"><?php echo esc_html__( 'Count of Caliper queue entries: ', 'wp_caliper' ) . '<span id="wp_caliper_run_queue_count">' . esc_html( $count ) . '</span>'; ?></div>
		<?php
	}

	/**
	 * Outputs radio kill switch to stop all events being emitted to LRS
	 *
	 * @return void
	 */
	public function wp_caliper_disabled_render() {
		?>
		<input type='radio' name='wp_caliper_settings[wp_caliper_disabled]' value='No' <?php checked( $this->options['wp_caliper_disabled'], 'No' ); ?>>No
		<input type='radio' name='wp_caliper_settings[wp_caliper_disabled]' value='Yes' <?php checked( $this->options['wp_caliper_disabled'], 'Yes' ); ?>>Yes
		<?php
	}

	/**
	 * Outputs the network level LRS URL field
	 *
	 * @return void
	 */
	public function wp_caliper_host_render() {
		?>
		<input type='text' name='wp_caliper_settings[wp_caliper_host]' value='<?php echo esc_url( $this->options['wp_caliper_host'] ); ?>'>
		<?php
	}

	/**
	 * Outputs the network level LRS password field
	 *
	 * @return void
	 */
	public function wp_caliper_api_key_render() {
		?>
		<input type='text' name='wp_caliper_settings[wp_caliper_api_key]' value='<?php echo esc_attr( $this->options['wp_caliper_api_key'] ); ?>'>
		<?php
	}


	/**
	 * Outputs radio kill switch to stop all events being emitted to LRS
	 *
	 * @return void
	 */
	public function wp_caliper_disable_local_site_settings_render() {
		?>
		<input type='radio' name='wp_caliper_settings[wp_caliper_disable_local_site_settings]' value='No' <?php checked( $this->options['wp_caliper_disable_local_site_settings'], 'No' ); ?>>No
		<input type='radio' name='wp_caliper_settings[wp_caliper_disable_local_site_settings]' value='Yes' <?php checked( $this->options['wp_caliper_disable_local_site_settings'], 'Yes' ); ?>>Yes
		<?php
	}

	/**
	 * Outputs a list of URLs that the site level LRSs will be compared to.
	 *
	 * - one URL on each line
	 * - it will check by seeing if the start of the URL will match one of these
	 *
	 * NOTE: special thanks to https://github.com/ubc/wiki-embed for the idea of doing it this way.
	 */
	public function wp_caliper_host_whitelist_render() {
		?>
		<textarea name='wp_caliper_settings[wp_caliper_host_whitelist]'  rows="10" cols="50"><?php echo esc_textarea( $this->options['wp_caliper_host_whitelist'] ); ?></textarea>
		<div class="help-div">We are checking only if the beginning of the url starts with the url that you provided.  So for example: <em>http://lrs.example.org/</em> would work but <em>http://events.lrs.example.org/</em> will not work</div>
		<p><strong>Currently allowed urls:</strong><br />
		<?php
		if ( ! isset( $this->options['wp_caliper_host_whitelist'] ) || empty( $this->options['wp_caliper_host_whitelist'] ) ) {
			echo '<em>' . esc_html__( 'No currently whitelisted URLs', 'wp_caliper' ) . '</em>';
		} else {
			foreach ( preg_split( '/\r\n|\r|\n/', $this->options['wp_caliper_host_whitelist'] ) as $link ) {
				echo esc_url( $link ) . '<br />';
			}
		}
	}

	/**
	 * Placeholder for title of section.
	 *
	 * @return string
	 */
	public function wp_caliper_section_callback() {
		return '';
	}

	/**
	 * Sanitizes user input.
	 *
	 * - sets value of checkbox to 0 if unselected.  ( Default WP behaviour is to not save the key even in options table. )
	 * - also checks if URL of local LRS is acceptable based on values set by network level settings
	 *
	 * @param array $input input.
	 * @return array
	 */
	public static function wp_caliper_sanitize_options( $input ) {
		// checks to see if lrs endpoint is whitelisted.
		$host            = $input['wp_caliper_host'];
		$network_options = get_site_option( 'wp_caliper_network_settings' );
		$host_whitelist  = preg_split( '/\r\n|\r|\n/', $network_options['wp_caliper_host_whitelist'] );
		if ( ! empty( $host_whitelist ) ) {
			$white_list_pass = false;
			if ( ! empty( $host ) ) {
				foreach ( $host_whitelist as $check_url ) {
					if ( substr( $host, 0, strlen( $check_url ) ) === $check_url ) {
						$white_list_pass = true;
						break;
					}
				}
				if ( ! $white_list_pass ) {
					add_settings_error(
						'wpCaliperHostInvalid',
						'wp-caliper-invalid-host',
						__( 'You have entered an invalid Host', 'wp_caliper' ),
						'error'
					);
					$input['wp_caliper_host'] = '';
				}
			}
		}
		return $input;
	}


	/**
	 * Runs the queue and returns json response with count and message.
	 */
	public static function wp_caliper_check_and_run_queue() {
		check_ajax_referer( 'wp_ajax_caliper_run_queue', 'security' );

		$finished = WP_Caliper::wp_caliper_run_the_queue();
		$count    = array(
			'count'   => 0,
			'message' => 'The queue had issues and could not run.',
		);
		if ( $finished ) {
			$count['count']   = WP_Caliper::caliper_queue_size();
			$count['message'] = __( 'The queue ran successfully!' );
		}
		wp_send_json( $count );
	}

	/**
	 * Function to output simple javascript.
	 */
	public static function wp_caliper_add_js() {
		$nonce = wp_create_nonce( 'wp_ajax_caliper_run_queue' );
		$url   = admin_url( 'admin-ajax.php' );
		if ( is_network_admin() || is_admin() ) {
			?>
				<script type='text/javascript' id='holdemhat'>
					jQuery( document ).ready( function() {
						var data = {
							'action': 'wp_caliper_check_and_run_queue',
							'security': '<?php echo esc_html( $nonce ); ?>'
						};
						var network_ajax_url = '<?php echo esc_html( $url ); ?>';
						jQuery( '#wp_caliper_run_queue' ).on( 'click', function() {
							jQuery.post( network_ajax_url, data, function( response ) {
								jQuery( '#wp_caliper_run_queue_count' ).text( response.count );
								alert( response.message );
							} );
							return false;
						} );
					} );
				</script>
			<?php
		}
	}
}
