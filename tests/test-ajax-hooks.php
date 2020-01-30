<?php
/**
 * Class WP_Caliper
 *
 * @package WP_Caliper
 */

use WPCaliperPlugin\caliper\CaliperSensor;

/**
 * Hook tests case.
 */
class AjaxHookTest extends WP_Ajax_UnitTestCase {

	/**
	 * Setup tests
	 */
	function setUp() {
		global $wp_version;
		parent::setUp();

		$this->home_url = is_multisite() ? 'http://example.org/' : 'http://example.org';

		$this->user = self::factory()->user->create_and_get(
			array(
				'display_name' => 'mock_display_name',
				'role'         => 'administrator',
			)
		);
		wp_set_current_user( $this->user->ID );

		$this->expected_ed_app = array(
			'id'      => $this->home_url,
			'type'    => 'SoftwareApplication',
			'name'    => 'WordPress',
			'version' => $wp_version,
		);

		$this->expected_actor = array(
			'id'          => 'http://test.homepage.com/' . $this->user->ID,
			'type'        => 'Person',
			'name'        => 'mock_display_name',
			'dateCreated' => $this->wp_date_to_iso8601( $this->user->user_registered ),
		);

		CaliperSensor::is_test( true );

		/*
		 * To enable automatic emitting to certification suite
		 * uncomment the line below and add the cert suite host & key
		 * in the `_enable_caliper` section
		 * (both wp_caliper_network_settings and wp_caliper_settings).
		 */
		/* CaliperSensor::send_test_events( true ); */
	}

	/**
	 * Tear down tests
	 */
	function tearDown() {
		CaliperSensor::is_test( false );
		CaliperSensor::send_test_events( false );
		parent::tearDown();
	}

	/**
	 * Helper function
	 */
	function wp_date_to_iso8601( $string ) {
		$timestamp = \DateTime::createFromFormat( 'Y-m-d H:i:s', $string );
		$timestamp->setTimezone( new \DateTimeZone( 'UTC' ) );
		return substr( $timestamp->format( 'Y-m-d\TH:i:s.u' ), 0, -3 ) . 'Z'; // truncate μs to ms.
	}

	/**
	 * Validate and remove common fields
	 */
	function cleanup_event_json( $event_json ) {

		$envelope = json_decode( $event_json, true );

		$this->assertSame( $envelope['sensor'], $this->home_url );
		$this->assertNotNull( $envelope['sendTime'] );
		$this->assertSame( $envelope['dataVersion'], 'http://purl.imsglobal.org/ctx/caliper/v1p2' );
		$this->assertCount( 1, $envelope['data'] );

		$event = $envelope['data'][0];
		$this->assertSame( $event['@context'], 'http://purl.imsglobal.org/ctx/caliper/v1p2' );
		unset( $event['@context'] );

		$this->assertNotNull( $event['id'] );
		unset( $event['id'] );

		$this->assertNotNull( $event['eventTime'] );
		unset( $event['eventTime'] );

		$this->assertSame( $event['edApp'], $this->expected_ed_app );
		unset( $event['edApp'] );

		$this->assertSame( $event['actor'], $this->expected_actor );
		unset( $event['actor'] );

		$this->assertNotNull( $event['session']['id'] );
		unset( $event['session']['id'] );

		$this->assertNotNull( $event['session']['client']['id'] );
		unset( $event['session']['client']['id'] );

		$this->assertSame(
			$event['session'],
			array(
				'type'   => 'Session',
				'client' => array(
					'type'      => 'SoftwareApplication',
					'host'		=> 'example.org',
					'ipAddress' => '127.0.0.1',
				),
				'user'   => $this->expected_actor,
			)
		);
		unset( $event['session'] );

		return $event;
	}

	/**
	 * Enable Caliper for tests
	 */
	function _enable_caliper() {
		add_site_option(
			'wp_caliper_network_settings',
			array(
				'wp_caliper_disabled'                    => 'No',
				'wp_caliper_host'                        => 'http://some.host.com:3333/caliper/endpoint',
				'wp_caliper_api_key'                     => 'some_api_key',
				'wp_caliper_disable_local_site_settings' => 'No',
				'wp_caliper_host_whitelist'              => '',
			)
		);

		add_option(
			'wp_caliper_settings',
			array(
				'wp_caliper_disabled' => 'No',
				'wp_caliper_host'     => 'http://some.host.com:3333/caliper/endpoint',
				'wp_caliper_api_key'  => 'some_api_key',
			)
		);

		update_option( 'siteurl', 'http://example.org' );
		update_option( 'home', 'http://example.org' );

		WPCaliperPlugin\WP_Caliper::init();
	}

	/**
	 * Test admin_post_wp_caliper_log_link_click/admin_post_nopriv_wp_caliper_log_link_click hook
	 */
	function test_wp_caliper_log_link_click() {
		global $_POST;
		$_POST['security']            = wp_create_nonce( 'caliper-click-log-nonce' );
		$_POST['click_url_requested'] = 'http%3A%2F%2Fsome.other.website.com%2F';

		$expected_event = array(
			'type'       => 'NavigationEvent',
			'profile'    => 'ReadingProfile',
			'action'     => 'NavigatedTo',
			'object'     => array(
				'id'   => 'http://some.other.website.com/',
				'type' => 'WebPage',
			),
			'extensions' => array(
				'linkClick'        => true,
				'requesterSiteUrl' => 'http://example.org',
				'queryString'      => '',
				'absolutePath'     => 'http://some.other.website.com/',
				'absoluteUrl'      => 'http://some.other.website.com/',
			),
		);
		$this->_enable_caliper();

		try {
			$this->_handleAjax( 'admin_post_wp_caliper_log_link_click' );
		} catch ( WPAjaxDieStopException $e ) {
			// skip.
		}

		WPCaliperPlugin\wp_caliper_log_link_click();
		$envelopes = CaliperSensor::get_envelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );
	}
}
