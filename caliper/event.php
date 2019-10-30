<?php
namespace WPCaliperPlugin\caliper;

use WPCaliperPlugin\caliper\ResourceIRI;
use WPCaliperPlugin\caliper\CaliperActor;
use WPCaliperPlugin\caliper\CaliperEntity;
use IMSGlobal\Caliper\events\Event;

class CaliperEvent {
	public static function addDefaults( Event &$event, \WP_User &$user ) {
		$event->setActor( CaliperActor::generateActor( $user ) );
		$event->setSession( CaliperEntity::session( $user ) );
		$event->setEdApp( CaliperEntity::wordPress() );

		if ( ! $event->getEventTime() ) {
			$event->setEventTime( new \DateTime( '@' . time() ) );
		}

		$extensions = $event->getExtensions() ?: [];
		if ( array_key_exists( 'HTTP_USER_AGENT-AGENT', $_SERVER ) ) {
			$extensions['browser-info']['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
		}
		if ( array_key_exists( 'HTTP_REFERER', $_SERVER ) ) {
			$extensions['browser-info']['referer'] = $_SERVER['HTTP_REFERER'];
		}

		// get ip address if available.
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$extensions['browser-info']['ipAddress'] = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$extensions['browser-info']['ipAddress'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$extensions['browser-info']['ipAddress'] = $_SERVER['REMOTE_ADDR'];
		}

		if ( [] !== $extensions ) {
			$event->setExtensions( $extensions );
		}
	}
}