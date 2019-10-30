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

		$this->post = $this->factory->post->create_and_get();
		$this->go_to( get_permalink( $this->post->ID ) );

		$this->comment = $this->factory->comment->create_and_get(
			array(
				'user_id'            => $this->user->ID,
				'comment_author_url' => 'http://example.com/' . $this->user->ID . '/',
				'comment_post_ID'    => $this->post->ID,
			)
		);

		// update post data for comment count.
		$this->post = get_post( $this->post->ID );

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

		$this->expected_site = array(
			'id'          => 'http://example.org',
			'type'        => 'DigitalResource',
			'name'        => 'Test Blog',
			'description' => 'Just another WordPress site',
		);

		$this->expected_post = array(
			'id'           => 'http://example.org?p=' . $this->post->ID,
			'type'         => 'WebPage',
			'name'         => get_the_title( $this->post ),
			'description'  => $this->post->post_content,
			'extensions'   => array(
				'post'          => true,
				'permalink'     => 'http://example.org/?p=' . $this->post->ID,
				'postType'      => 'post',
				'postStatus'    => 'publish',
				'commentStatus' => 'open',
				'pingStatus'    => 'open',
				'commentCount'  => '1',
				'menuOrder'     => 0,
			),
			'dateCreated'  => $this->wp_date_to_iso8601( $this->post->post_date ),
			'dateModified' => $this->wp_date_to_iso8601( $this->post->post_modified ),
			'creators'     => array(
				$this->expected_actor,
			),
			'isPartOf'     => $this->expected_site,
		);

		$this->expected_comment = array(
			'id'          => 'http://example.org?p=' . $this->post->ID . '#comment=' . $this->comment->comment_ID,
			'type'        => 'Message',
			'extensions'  => array(
				'karma'     => '0',
				'approved'  => '1',
				'type'      => '',
				'authorUrl' => 'http://example.com/' . $this->user->ID.'/',
			),
			'dateCreated' => $this->wp_date_to_iso8601( $this->comment->comment_date ),
			'isPartOf'    => $this->expected_post,
			'body'        => 'This is a comment',
		);

		CaliperSensor::setSendEvents( false );
	}

	function tearDown() {
		parent::tearDown();
	}

	function wp_date_to_iso8601( $string ) {
		$timestamp = \DateTime::createFromFormat( 'Y-m-d H:i:s', $string );
		$timestamp->setTimezone( new \DateTimeZone( 'UTC' ) );
		return substr( $timestamp->format( 'Y-m-d\TH:i:s.u' ), 0, -3 ) . 'Z'; // truncate μs to ms.
	}

	function cleanup_event_json( $event_json ) {

		$envelope = json_decode( $event_json, true );

		$this->assertSame( $envelope['sensor'], $this->home_url );
		$this->assertNotNull( $envelope['sendTime'] );
		$this->assertSame( $envelope['dataVersion'], 'http://purl.imsglobal.org/ctx/caliper/v1p1' );
		$this->assertCount( 1, $envelope['data'] );

		$event = $envelope['data'][0];
		$this->assertSame( $event['@context'], 'http://purl.imsglobal.org/ctx/caliper/v1p1' );
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

		$this->assertSame(
			$event['session'],
			array(
				'type' => 'Session',
				'user' => $this->expected_actor,
			)
		);
		unset( $event['session'] );

		return $event;
	}

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
		$_POST['blog_id']             = 1;

		$expected_event = array(
			'type'       => 'NavigationEvent',
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
				'browser-info'     => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		try {
			$this->_handleAjax( 'admin_post_wp_caliper_log_link_click' );
		} catch ( WPAjaxDieStopException $e ) {
			// skip.
		}

		WPCaliperPlugin\wp_caliper_log_link_click();
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );
	}
}
