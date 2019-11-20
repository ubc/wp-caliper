<?php
namespace WPCaliperPlugin\caliper;

/**
 * Handles Internationalized Resource Identifiers
 */
class ResourceIRI {
	/**
	 * Get home url
	 */
	public static function get_home_url() {
		return home_url();
	}

	/**
	 * Get site url
	 */
	public static function get_site_url() {
		return site_url();
	}

	/**
	 * Get site api url
	 */
	public static function get_site_api_url() {
		return self::get_site_url() . '/' . get_option( 'json_api_base', 'api' );
	}

	/**
	 * Get current page url
	 */
	public static function current_page_url() {
		$page_url = 'http';
		if ( isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ) {
			$page_url .= 's';
		}
		$page_url .= '://';
		if ( isset( $_SERVER['SERVER_PORT'] ) && '443' !== $_SERVER['SERVER_PORT'] && '' !== $_SERVER['SERVER_PORT'] && '80' !== $_SERVER['SERVER_PORT'] ) {
			$page_url .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
		} else {
			$page_url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		}
		return $page_url;
	}

	/**
	 * Get WordPress iri
	 */
	public static function word_press() {
		return function_exists( 'network_home_url' ) ? network_home_url() : home_url();
	}

	/**
	 * Get user session iri
	 */
	public static function user_session( $session_id ) {
		return self::get_home_url() . '/session/' . $session_id;
	}

	/**
	 * Get user client iri
	 */
	public static function user_client( $session_id ) {
		return self::user_session( $session_id ) . '#client';
	}

	/**
	 * Get site iri
	 */
	public static function site( $blog_id = null ) {
		return get_site_url( $blog_id );
	}

	/**
	 * Get post iri
	 */
	public static function post( $post_id ) {
		// return get_permalink( $post_id );.
		return self::get_site_url() . '?p=' . $post_id;
	}

	/**
	 * Get comment iri
	 */
	public static function comment( $post_id, $comment_id ) {
		return self::post( $post_id ) . '#comment=' . $comment_id;
	}

	/**
	 * Get badge assertion iri
	 */
	public static function badge_assertion( $assertion_uid ) {
		return self::get_site_api_url() . '/badge/assertion/?uid=' . $assertion_uid;
	}

	/**
	 * Get badge issuer iri
	 */
	public static function badge_issuer() {
		return self::get_site_api_url() . '/badge/issuer/';
	}

	/**
	 * Get badge class iri
	 */
	public static function badge_class( $post_id ) {
		return self::get_site_api_url() . '/badge/badge_class/?uid=' . $post_id;
	}

	/**
	 * Get badge image iri
	 */
	public static function badge_image( $post_id ) {
		return wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
	}

	/**
	 * Get web page url/iri
	 */
	public static function webpage( $absolute_url ) {
		return $absolute_url;
	}

	/**
	 * Get pulse press vote question iri
	 */
	public static function pulse_press_vote_question() {
		return self::get_site_url() . '#pulse_press_vote_question';
	}

	/**
	 * Get pulse press vote question iri
	 */
	public static function pulse_press_vote_scale() {
		return self::get_site_url() . '#pulse_press_vote_scale';
	}

	/**
	 * Get pulse press star question iri
	 */
	public static function pulse_press_star_question() {
		return self::get_site_url() . '#pulse_press_star_question';
	}

	/**
	 * Get pulse press vote question iri
	 */
	public static function pulse_press_star_scale() {
		return self::get_site_url() . '#pulse_press_star_scale';
	}

	/**
	 * Get pulse press vote rating iri
	 */
	public static function pulse_press_vote_rating( $post_id, $user_id ) {
		return self::post( $post_id ) . '&uid=' . $user_id . '#pulse_press_vote';
	}

	/**
	 * Get pulse press star rating iri
	 */
	public static function pulse_press_star_rating( $post_id, $user_id ) {
		return self::post( $post_id ) . '&uid=' . $user_id . '#pulse_press_star';
	}

}
