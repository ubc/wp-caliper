<?php
namespace WPCaliperPlugin\caliper;

use IMSGlobal\Caliper\entities\agent\Person;

/**
 * Handles Caliper Actors
 */
class CaliperActor {
	/**
	 * Generates a WordPress actor with overridable homepage and id
	 */
	private static function _generate_actor( \WP_User &$user ) {
		// load user data to get external unique identifier.
		$user_data = get_userdata( $user->ID );
		$unique_id = get_user_meta( $user_data->ID, WP_CALIPER_DEFAULT_ACTOR_IDENTIFIER, true );
		$unique_id = apply_filters( 'wp_caliper_actor_identifier', $unique_id, $user->ID, $user_data );

		if ( empty( $unique_id ) ) {
			error_log( '[wp-caliper] Please ensure that the WP_CALIPER_DEFAULT_ACTOR_IDENTIFIER constant in wp-caliper-configs.php file is set properly!' );
			return null;
		}

		// base url for external user.
		$base_url = apply_filters( 'wp_caliper_actor_homepage', WP_CALIPER_DEFAULT_ACTOR_HOMEPAGE );
		$base_url = rtrim( $base_url, '/' );

		if ( empty( $base_url ) ) {
			error_log( '[wp-caliper] Please ensure that the WP_CALIPER_DEFAULT_ACTOR_HOMEPAGE constant in wp-caliper-configs.php file is set properly!' );
			return null;
		}

		// load user data to get external unique identifier.
		return ( new Person( $base_url . '/' . $unique_id ) )
			->setName( $user_data->display_name )
			->setDateCreated( \DateTime::createFromFormat( 'Y-m-d H:i:s', $user_data->user_registered ) );
	}

	/**
	 * Generates a Caliper actor
	 */
	public static function generate_actor( \WP_User &$user ) {
		// happens when not logged in.
		if ( ! $user->ID ) {
			return Person::makeAnonymous();
		}
		$actor = self::_generate_actor( $user );
		return apply_filters( 'wp_caliper_actor', $actor, $user );
	}
}
