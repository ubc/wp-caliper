<?php
/**
 * Collection of hooks which send Caliper events.
 *
 * @package wp-caliper
 */

namespace WPCaliperPlugin;

use IMSGlobal\Caliper\events\Event;
use IMSGlobal\Caliper\events\FeedbackEvent;
use IMSGlobal\Caliper\events\ResourceManagementEvent;
use IMSGlobal\Caliper\events\NavigationEvent;
use IMSGlobal\Caliper\events\SessionEvent;

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\profiles\Profile;

use WPCaliperPlugin\caliper\ResourceIRI;
use WPCaliperPlugin\caliper\CaliperEntity;
use WPCaliperPlugin\caliper\CaliperSensor;

add_action( 'wp_enqueue_scripts', 'WPCaliperPlugin\\wp_caliper_enqueue_script', 10, 0 );
/**
 * Add Frontend tracking ( link click )
 */
function wp_caliper_enqueue_script() {
	$wp_caliper_post_id = base64_encode( $wp_caliper_post_id );

	wp_enqueue_script( 'sendbeacon', plugins_url( '/js/sendbeacon_polyfill.js', __FILE__ ) );
	wp_enqueue_script( 'wp_caliper_script', plugins_url( '/js/wp_caliper_js_log.js', __FILE__ ), array( 'jquery', 'sendbeacon' ) );
	wp_localize_script(
		'wp_caliper_script',
		'wp_caliper_link_log_object',
		array(
			'site_url' => site_url(),
			'url'      => admin_url( 'admin-post.php' ),
			'security' => wp_create_nonce( 'caliper-click-log-nonce' ),
		)
	);
}

add_action( 'admin_post_wp_caliper_log_link_click', 'WPCaliperPlugin\\wp_caliper_log_link_click', 10, 0 );
add_action( 'admin_post_nopriv_wp_caliper_log_link_click', 'WPCaliperPlugin\\wp_caliper_log_link_click', 10, 0 );
/**
 * Track link clicks
 */
function wp_caliper_log_link_click() {
	check_ajax_referer( 'caliper-click-log-nonce', 'security' );

	$click_url_requested = urldecode( $_POST['click_url_requested'] );
	$click_url_requested = sanitize_text_field( $click_url_requested );

	$event = ( new NavigationEvent() )
		->setProfile( new Profile( Profile::READING ) )
		->setAction( new Action( Action::NAVIGATED_TO ) )
		->setObject( CaliperEntity::webpage( $click_url_requested ) );

	$query_string = explode( '?', $click_url_requested );
	$query_string = count( $query_string ) > 1 ? $query_string[1] : '';
	$event->setExtensions(
		array(
			'linkClick'        => true,
			'requesterSiteUrl' => ResourceIRI::site( get_current_blog_id() ),
			'queryString'      => $query_string,
			'absolutePath'     => preg_replace( '/\?.*|\#.*/', '', $click_url_requested ),
			'absoluteUrl'      => $click_url_requested,
		)
	);

	CaliperSensor::send_event( $event, wp_get_current_user() );
}

add_action( 'badgeos_award_achievement', 'WPCaliperPlugin\\wp_caliper_badgeos_award_achievement', 10, 2 );
/**
 * This is for badge earning events
 * args parameter should return $user_id, $achievement_id, $this_trigger, $site_id, $args
 *
 * @param integer $user_id user id.
 * @param integer $achievement_id achievement id.
 */
function wp_caliper_badgeos_award_achievement( $user_id, $achievement_id ) {
	if ( empty( $achievement_id ) ) {
		return;
	}

	$current_user = get_userdata( $user_id );
	$post         = get_post( $achievement_id );
	if ( empty( $current_user ) || empty( $post ) ) {
		return;
	}

	// check that it is a badge and NOT a step.
	if ( 'step' === get_post_type( $post ) ) {
		return;
	}

	$assertion_uid = $post->ID . '-' . get_post_time( 'U', true ) . '-' . $current_user->ID;

	$event = ( new Event() )
		->setProfile( new Profile( Profile::GENERAL ) )
		->setAction( new Action( Action::COMPLETED ) )
		->setObject( CaliperEntity::post( $post ) );

	$event->setExtensions(
		array(
			'badgeEarned'    => true,
			'badgeAssertion' => ResourceIRI::badge_assertion( $assertion_uid ),
		)
	);

	CaliperSensor::send_event( $event, $current_user );
}

add_action( 'shutdown', 'WPCaliperPlugin\\wp_caliper_shutdown', 10, 0 );
/**
 * This trigger is for page views of various kinds
 */
function wp_caliper_shutdown() {
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}
	if ( is_admin() ) {
		return;
	}

	if ( ! is_singular() && ! is_page() && ! is_attachment() && ! is_front_page() && ! is_home() ) {
		return;
	}

	$post        = get_post();
	$current_url = ResourceIRI::current_page_url();

	$event = ( new NavigationEvent() )
		->setProfile( new Profile( Profile::READING ) )
		->setAction( new Action( Action::NAVIGATED_TO ) );

	if ( is_home() ) {
		$event->setObject( CaliperEntity::site( get_current_blog_id() ) );
	} elseif ( $post && ! empty( $post->ID ) ) {
		$event->setObject( CaliperEntity::post( $post ) );
	} else {
		$event->setObject( CaliperEntity::webpage( $current_url ) );
	}

	$query_string = explode( '?', $current_url );
	$query_string = count( $query_string ) > 1 ? $query_string[1] : '';
	$event->setExtensions(
		array(
			'queryString'  => $query_string,
			'absolutePath' => preg_replace( '/\?.*|\#.*/', '', $current_url ),
			'absoluteUrl'  => $current_url,
		)
	);

	CaliperSensor::send_event( $event, wp_get_current_user() );
}


add_action( 'comment_post', 'WPCaliperPlugin\\wp_caliper_comment_post', 10, 1 );
/**
 * This trigger is for tracking new comments
 *
 * @param integer $comment_id comment id.
 */
function wp_caliper_comment_post( $comment_id ) {
	if ( empty( $comment_id ) ) {
		return;
	}

	$comment = get_comment( $comment_id );
	if ( empty( $comment ) ) {
		return;
	}

	$event = ( new ResourceManagementEvent() )
		->setProfile( new Profile( Profile::RESOURCE_MANAGEMENT ) )
		->setAction( new Action( Action::CREATED ) )
		->setObject( CaliperEntity::comment( $comment ) );

	CaliperSensor::send_event( $event, wp_get_current_user() );
}

add_action( 'edit_comment', 'WPCaliperPlugin\\wp_caliper_edit_comment', 10, 1 );
/**
 * This trigger is for tracking comment edits
 *
 * @param integer $comment_id comment id.
 */
function wp_caliper_edit_comment( $comment_id ) {
	if ( empty( $comment_id ) ) {
		return;
	}

	$comment = get_comment( $comment_id );
	if ( empty( $comment ) ) {
		return;
	}

	$event = ( new ResourceManagementEvent() )
		->setProfile( new Profile( Profile::RESOURCE_MANAGEMENT ) )
		->setAction( new Action( Action::MODIFIED ) )
		->setObject( CaliperEntity::comment( $comment ) );

	CaliperSensor::send_event( $event, wp_get_current_user() );
}

add_action( 'transition_comment_status', 'WPCaliperPlugin\\wp_caliper_transition_comment_status', 10, 3 );
/**
 * This trigger is to track some specific comment transitions ( going to published, trashed, etc )
 *
 * @param integer $new_status new status.
 * @param integer $old_status old status.
 * @param object  $comment comment.
 */
function wp_caliper_transition_comment_status( $new_status, $old_status, $comment ) {
	if ( empty( $comment ) || empty( $comment->comment_ID ) ) {
		return;
	}

	$event = ( new ResourceManagementEvent() )
		->setProfile( new Profile( Profile::RESOURCE_MANAGEMENT ) )
		->setObject( CaliperEntity::comment( $comment ) );

	if ( 'trash' === $new_status ) {
		$event->setAction( new Action( Action::DELETED ) );
	} elseif ( 'approved' === $old_status && 'approved' !== $new_status ) {
		$event->setAction( new Action( Action::UNPUBLISHED ) );
	} elseif ( 'approved' === $new_status && 'approved' !== $old_status ) {
		$event->setAction( new Action( Action::PUBLISHED ) );
	} else {
		return;
	}

	CaliperSensor::send_event( $event, wp_get_current_user() );
}

add_action( 'pulse_press_vote_up', 'WPCaliperPlugin\\wp_caliper_pulse_press_vote_up', 10, 1 );
/**
 * PulsePress theme vote up
 *
 * @param string|integer $post_id $post id.
 */
function wp_caliper_pulse_press_vote_up( $post_id ) {
	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );

	$event = ( new FeedbackEvent() )
		->setProfile( new Profile( Profile::FEEDBACK ) )
		->setAction( new Action( Action::RANKED ) )
		->setObject( CaliperEntity::post( $post ) )
		->setGenerated( CaliperEntity::pulse_press_vote_rating( wp_get_current_user(), $post, '1' ) );

	CaliperSensor::send_event( $event, wp_get_current_user() );
}

add_action( 'pulse_press_vote_down', 'WPCaliperPlugin\\wp_caliper_pulse_press_vote_down', 10, 1 );
/**
 * PulsePress theme vote down
 *
 * @param string|integer $post_id $post id.
 */
function wp_caliper_pulse_press_vote_down( $post_id ) {
	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );

	$event = ( new FeedbackEvent() )
		->setProfile( new Profile( Profile::FEEDBACK ) )
		->setAction( new Action( Action::RANKED ) )
		->setObject( CaliperEntity::post( $post ) )
		->setGenerated( CaliperEntity::pulse_press_vote_rating( wp_get_current_user(), $post, '-1' ) );

	CaliperSensor::send_event( $event, wp_get_current_user() );
}

add_action( 'pulse_press_vote_delete', 'WPCaliperPlugin\\wp_caliper_pulse_press_vote_delete', 10, 1 );
/**
 * PulsePress theme vote delete
 *
 * @param string|integer $post_id $post id.
 */
function wp_caliper_pulse_press_vote_delete( $post_id ) {
	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );

	$event = ( new FeedbackEvent() )
		->setProfile( new Profile( Profile::FEEDBACK ) )
		->setAction( new Action( Action::RANKED ) )
		->setObject( CaliperEntity::post( $post ) )
		->setGenerated( CaliperEntity::pulse_press_vote_rating( wp_get_current_user(), $post, '0' ) );

	CaliperSensor::send_event( $event, wp_get_current_user() );
}

add_action( 'pulse_press_star_add', 'WPCaliperPlugin\\wp_caliper_pulse_press_star_add', 10, 1 );
/**
 * PulsePress theme star/favorite
 *
 * @param string|integer $post_id $post id.
 */
function wp_caliper_pulse_press_star_add( $post_id ) {
	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );

	$event = ( new FeedbackEvent() )
		->setProfile( new Profile( Profile::FEEDBACK ) )
		->setAction( new Action( Action::RANKED ) )
		->setObject( CaliperEntity::post( $post ) )
		->setGenerated( CaliperEntity::pulse_press_star_rating( wp_get_current_user(), $post, 'true' ) );

	CaliperSensor::send_event( $event, wp_get_current_user() );
}

add_action( 'pulse_press_star_delete', 'WPCaliperPlugin\\wp_caliper_pulse_press_star_delete', 10, 1 );
/**
 * PulsePress theme star/favorite delete
 *
 * @param string|integer $post_id $post id.
 */
function wp_caliper_pulse_press_star_delete( $post_id ) {
	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );

	$event = ( new FeedbackEvent() )
		->setProfile( new Profile( Profile::FEEDBACK ) )
		->setAction( new Action( Action::RANKED ) )
		->setObject( CaliperEntity::post( $post ) )
		->setGenerated( CaliperEntity::pulse_press_star_rating( wp_get_current_user(), $post, 'false' ) );

	CaliperSensor::send_event( $event, wp_get_current_user() );
}

add_action( 'save_post', 'WPCaliperPlugin\\wp_caliper_save_post', 10, 3 );
/**
 * This trigger is to track creation edits to posts
 *
 * @param string|integer $post_id post id.
 * @param \WP_POST       $post post.
 * @param bool           $update update.
 */
function wp_caliper_save_post( $post_id, $post, $update ) {
	if ( empty( $post_id ) ) {
		return;
	}

	$post_type = get_post_type( $post );
	// do not log badge log entries.
	if ( 'badgeos-log-entry' === $post_type ) {
		return;
	}

	$event = ( new ResourceManagementEvent() )
		->setProfile( new Profile( Profile::RESOURCE_MANAGEMENT ) )
		->setObject( CaliperEntity::post( $post ) );

	if ( $update ) {
		$event->setAction( new Action( Action::MODIFIED ) );
	} else {
		$event->setAction( new Action( Action::CREATED ) );
	}

	CaliperSensor::send_event( $event, wp_get_current_user() );
}

add_action( 'transition_post_status', 'WPCaliperPlugin\\wp_caliper_transition_post_status', 10, 3 );
/**
 * This trigger is to track some specific post transitions ( going to published, trashed, etc )
 *
 * @param string   $new_status new status.
 * @param string   $old_status old status.
 * @param \WP_POST $post WordPress post object.
 */
function wp_caliper_transition_post_status( $new_status, $old_status, $post ) {
	if ( empty( $post ) || empty( $post->ID ) ) {
		return;
	}

	$post_type = get_post_type( $post );
	// do not log badge log entries.
	if ( 'badgeos-log-entry' === $post_type ) {
		return;
	}

	$event = ( new ResourceManagementEvent() )
		->setProfile( new Profile( Profile::RESOURCE_MANAGEMENT ) )
		->setObject( CaliperEntity::post( $post ) );

	if ( 'trash' === $new_status ) {
		$event->setAction( new Action( Action::DELETED ) );
	} elseif ( 'trash' === $old_status && 'trash' !== $new_status ) {
		$event->setAction( new Action( Action::RESTORED ) );
	} elseif ( 'publish' === $old_status && 'publish' !== $new_status ) {
		$event->setAction( new Action( Action::UNPUBLISHED ) );
	} elseif ( 'publish' === $new_status && 'publish' !== $old_status ) {
		$event->setAction( new Action( Action::PUBLISHED ) );
	} else {
		return;
	}

	CaliperSensor::send_event( $event, wp_get_current_user() );
}

add_action( 'add_attachment', 'WPCaliperPlugin\\wp_caliper_add_attachment', 10, 1 );
/**
 * This trigger is to track creation edits to posts
 *
 * @param string|integer $post_id post id.
 */
function wp_caliper_add_attachment( $post_id ) {
	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );

	$event = ( new ResourceManagementEvent() )
		->setProfile( new Profile( Profile::RESOURCE_MANAGEMENT ) )
		->setAction( new Action( Action::CREATED ) )
		->setObject( CaliperEntity::post( $post ) );

	CaliperSensor::send_event( $event, wp_get_current_user() );
}

add_action( 'wp_login', 'WPCaliperPlugin\\wp_caliper_wp_login', 10, 2 );
/**
 * This trigger is to track log in
 *
 * @param bool     $user_login user login.
 * @param \WP_USER $user WordPress user object.
 */
function wp_caliper_wp_login( $user_login = false, $user = false ) {
	if ( empty( $user->ID ) ) {
		return;
	}

	$event = ( new SessionEvent() )
		->setProfile( new Profile( Profile::SESSION ) )
		->setAction( new Action( Action::LOGGED_IN ) )
		->setObject( CaliperEntity::word_press() );

	CaliperSensor::send_event( $event, $user );
}

add_action( 'clear_auth_cookie', 'WPCaliperPlugin\\wp_caliper_clear_auth_cookie', 10, 0 );
/**
 * This trigger is to track log out ( must be done before cookie is cleared or else won't know who the user is )
 */
function wp_caliper_clear_auth_cookie() {
	$event = ( new SessionEvent() )
		->setProfile( new Profile( Profile::SESSION ) )
		->setAction( new Action( Action::LOGGED_OUT ) )
		->setObject( CaliperEntity::word_press() );

	CaliperSensor::send_event( $event, wp_get_current_user() );
}
