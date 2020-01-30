<?php
/**
 * Caliper Event decorator
 *
 * @package wp-caliper
 */

namespace WPCaliperPlugin\caliper;

use WPCaliperPlugin\caliper\CaliperActor;
use WPCaliperPlugin\caliper\CaliperEntity;
use IMSGlobal\Caliper\events\Event;

/**
 * Handles Caliper Events
 */
class CaliperEvent {
	/**
	 * Adds default info to an event
	 *
	 * @param Event    $event Caliper event object.
	 * @param \WP_User $user WordPress User.
	 */
	public static function add_defaults( Event &$event, \WP_User &$user ) {
		$event->setActor( CaliperActor::generate_actor( $user ) );
		$event->setSession( CaliperEntity::session( $user ) );
		$event->setEdApp( CaliperEntity::word_press() );

		if ( ! $event->getEventTime() ) {
			$event->setEventTime( new \DateTime( '@' . time() ) );
		}
	}
}
