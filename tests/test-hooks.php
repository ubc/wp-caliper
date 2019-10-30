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
class HookTest extends WP_UnitTestCase {

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
				'authorUrl' => 'http://example.com/' . $this->user->ID . '/',
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
		$this->assertSame( $envelope['dataVersion'], "http://purl.imsglobal.org/ctx/caliper/v1p1" );
		$this->assertCount( 1, $envelope['data'] );

		$event = $envelope['data'][0];
		if ( 'ResourceManagementEvent' === $event['type'] ) {
			$this->assertSame( $event['@context'], "http://purl.imsglobal.org/ctx/caliper/v1p1/ResourceManagementProfile-extension" );
		} else {
			$this->assertSame( $event['@context'], "http://purl.imsglobal.org/ctx/caliper/v1p1" );
		}
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
	 * Test badgeos_award_achievement hook
	 */
	function test_wp_caliper_badgeos_award_achievement() {
		$this->badge_award = $this->factory->post->create_and_get( array( 'post_type' => 'badges' ) );
		$this->badge_step  = $this->factory->post->create_and_get( array( 'post_type' => 'step' ) );

		$expected_event = array(
			'type'       => 'Event',
			'action'     => 'Completed',
			'object'     => array(
				'id'           => 'http://example.org?p=' . $this->badge_award->ID,
				'type'         => 'Document',
				'name'         => get_the_title( $this->badge_award ),
				'description'  => $this->badge_award->post_content,
				'extensions'   => array(
					'post'          => true,
					'permalink'     => 'http://example.org/?p=' . $this->badge_award->ID,
					'postType'      => 'badges',
					'postStatus'    => 'publish',
					'commentStatus' => 'closed',
					'pingStatus'    => 'closed',
					'commentCount'  => '0',
					'menuOrder'     => 0,
					'badgeClass'    => 'http://example.org/api/badge/badge_class/?uid=' . $this->badge_award->ID,
					'badgeIssuer'   => 'http://example.org/api/badge/issuer/',
					'badgeImage'    => false,
				),
				'dateCreated'  => $this->wp_date_to_iso8601( $this->badge_award->post_date ),
				'dateModified' => $this->wp_date_to_iso8601( $this->badge_award->post_modified ),
				'creators'     => array(
					$this->expected_actor,
				),
				'isPartOf'     => $this->expected_site,
			),
			'extensions' => array(
				'badgeEarned'  => true,

				/*
				 * hard test test badgeAssertion so do a basic test below
				 * 'badgeAssertion' => 'http://example.org/api/badge/assertion/?uid=5-1544833466-2',
				 */
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_badgeos_award_achievement( $this->user->ID, $this->badge_award->ID );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertNotNull( $actual_event['extensions']['badgeAssertion'] );
		unset( $actual_event['extensions']['badgeAssertion'] );
		$this->assertSame( $expected_event, $actual_event );

		WPCaliperPlugin\wp_caliper_badgeos_award_achievement( $this->user->ID, $this->badge_step->ID );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 0, $envelopes );
	}


	/**
	 * Test shutdown hook
	 */
	function test_wp_caliper_shutdown() {
		$expected_event = array(
			'type'       => 'NavigationEvent',
			'action'     => 'NavigatedTo',
			'object'     => array(
				'id'   => 'http://example.org/?p=' . $this->post->ID,
				'type' => 'WebPage',
			),
			'extensions' => array(
				'queryString'  => 'p=' . $this->post->ID,
				'absolutePath' => 'http://example.org/',
				'absoluteUrl'  => 'http://example.org/?p=' . $this->post->ID,
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_shutdown();
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );
	}


	/**
	 * Test comment_post hook
	 */
	function test_wp_caliper_comment_post() {
		$expected_event = array(
			'type'       => 'ResourceManagementEvent',
			'action'     => 'Created',
			'object'     => $this->expected_comment,
			'extensions' => array(
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_comment_post( $this->comment->comment_ID );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );
	}



	/**
	 * Test edit_comment hook
	 */
	function test_wp_caliper_edit_comment() {
		$expected_event = array(
			'type'       => 'ResourceManagementEvent',
			'action'     => 'Modified',
			'object'     => $this->expected_comment,
			'extensions' => array(
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_edit_comment( $this->comment->comment_ID );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );
	}

	/**
	 * Test transition_comment_status hook
	 */
	function test_wp_caliper_transition_comment_status() {
		$expected_event = array(
			'type'       => 'ResourceManagementEvent',
			'action'     => 'Published',
			'object'     => $this->expected_comment,
			'extensions' => array(
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_transition_comment_status( 'approved', 'some-other-status', $this->comment );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );

		$expected_event['action'] = 'Unpublished';
		WPCaliperPlugin\wp_caliper_transition_comment_status( 'some-other-status', 'approved', $this->comment );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );

		$expected_event['action'] = 'Deleted';
		WPCaliperPlugin\wp_caliper_transition_comment_status( 'trash', 'approved', $this->comment );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );

		WPCaliperPlugin\wp_caliper_transition_comment_status( 'some-status', 'some-other-status', $this->comment );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 0, $envelopes );
	}

	/**
	 * Test pulse_press_vote_up hook
	 */
	function test_wp_caliper_pulse_press_vote_up() {
		$expected_event = array(
			'type'       => 'Event',
			'action'     => 'Ranked',
			'object'     => $this->expected_post,
			'extensions' => array(
				'upVote'       => true,
				'vote'         => 1,
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_pulse_press_vote_up( $this->post->ID );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );
	}

	/**
	 * Test pulse_press_vote_down hook
	 */
	function test_wp_caliper_pulse_press_vote_down() {
		$expected_event = array(
			'type'       => 'Event',
			'action'     => 'Ranked',
			'object'     => $this->expected_post,
			'extensions' => array(
				'downVote'     => true,
				'vote'         => -1,
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_pulse_press_vote_down( $this->post->ID );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );
	}

	/**
	 * Test pulse_press_vote_delete hook
	 */
	function test_wp_caliper_pulse_press_vote_delete() {
		$expected_event = array(
			'type'       => 'Event',
			'action'     => 'Ranked',
			'object'     => $this->expected_post,
			'extensions' => array(
				'resetVote'    => true,
				'vote'         => 0,
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_pulse_press_vote_delete( $this->post->ID );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );
	}

	/**
	 * Test pulse_press_star_add hook
	 */
	function test_wp_caliper_pulse_press_star_add() {
		$expected_event = array(
			'type'       => 'Event',
			'action'     => 'Ranked',
			'object'     => $this->expected_post,
			'extensions' => array(
				'favorited'    => true,
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_pulse_press_star_add( $this->post->ID );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );
	}

	/**
	 * Test pulse_press_star_delete hook
	 */
	function test_wp_caliper_pulse_press_star_delete() {
		$expected_event = array(
			'type'       => 'Event',
			'action'     => 'Ranked',
			'object'     => $this->expected_post,
			'extensions' => array(
				'unfavorited'  => true,
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_pulse_press_star_delete( $this->post->ID );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );
	}

	/**
	 * Test save_post hook
	 */
	function test_wp_caliper_save_post() {
		$expected_event = array(
			'type'       => 'ResourceManagementEvent',
			'action'     => 'Created',
			'object'     => $this->expected_post,
			'extensions' => array(
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_save_post( $this->post->ID, $this->post, false );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );

		$expected_event['action'] = 'Modified';
		WPCaliperPlugin\wp_caliper_save_post( $this->post->ID, $this->post, true );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );

		$this->badge_log = $this->factory->post->create_and_get(
			array(
				'post_type' => 'badgeos-log-entry',
			)
		);
		WPCaliperPlugin\wp_caliper_save_post( $this->badge_log->ID, $this->badge_log, false );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 0, $envelopes );
	}

	/**
	 * Test transition_post_status hook
	 */
	function test_wp_caliper_transition_post_status() {
		$expected_event = array(
			'type'       => 'ResourceManagementEvent',
			'action'     => 'Published',
			'object'     => $this->expected_post,
			'extensions' => array(
				'browser-info'  => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_transition_post_status( 'publish', 'some-other-status', $this->post );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );

		$expected_event['action'] = 'Unpublished';
		WPCaliperPlugin\wp_caliper_transition_post_status( 'some-other-status', 'publish', $this->post );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );

		$expected_event['action'] = 'Deleted';
		WPCaliperPlugin\wp_caliper_transition_post_status( 'trash', 'publish', $this->post );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );

		WPCaliperPlugin\wp_caliper_transition_post_status( 'some-status', 'some-other-status', $this->post );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 0, $envelopes );
	}

	/**
	 * Test add_attachment hook
	 */
	function test_wp_caliper_add_attachment() {
		$this->attachment = $this->factory->post->create_and_get(
			array(
				'post_type' => 'attachment',
			)
		);

		$this->expected_attachment_post = array(
			'id'           => 'http://example.org?p=' . $this->attachment->ID,
			'type'         => 'Document',
			'name'         => get_the_title( $this->attachment ),
			'description'  => $this->attachment->post_content,
			'extensions'   => array(
				'post' => true,
				'permalink'     => 'http://example.org/?attachment_id=' . $this->attachment->ID,
				'postType'      => 'attachment',
				'postStatus'    => 'inherit',
				'commentStatus' => 'open',
				'pingStatus'    => 'closed',
				'commentCount'  => '0',
				'menuOrder'     => 0,
			),
			'dateCreated'  => $this->wp_date_to_iso8601( $this->attachment->post_date ),
			'dateModified' => $this->wp_date_to_iso8601( $this->attachment->post_modified ),
			'creators'     => array( $this->expected_actor ),
			'isPartOf'     => $this->expected_site,
		);

		$expected_event = array(
			'type'       => 'ResourceManagementEvent',
			'action'     => 'Created',
			'object'     => $this->expected_attachment_post,
			'extensions' => array(
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_add_attachment( $this->attachment->ID );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );
	}

	/**
	 * Test wp_login hook
	 */
	function test_wp_caliper_wp_login() {
		$expected_event = array(
			'type'       => 'SessionEvent',
			'action'     => 'LoggedIn',
			'object'     => $this->expected_ed_app,
			'extensions' => array(
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_wp_login( null, $this->user );
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );
	}

	/**
	 * Test clear_auth_cookie hook
	 */
	function test_wp_caliper_clear_auth_cookie() {
		$expected_event = array(
			'type'       => 'SessionEvent',
			'action'     => 'LoggedOut',
			'object'     => $this->expected_ed_app,
			'extensions' => array(
				'browser-info' => array(
					'ipAddress' => '127.0.0.1',
				),
			),
		);
		$this->_enable_caliper();

		WPCaliperPlugin\wp_caliper_clear_auth_cookie();
		$envelopes = CaliperSensor::getEnvelopes();

		$this->assertCount( 1, $envelopes );
		$actual_event = $this->cleanup_event_json( $envelopes[0] );
		$this->assertSame( $expected_event, $actual_event );
	}
}
